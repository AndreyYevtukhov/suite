<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer;

use Generated\Shared\Transfer\SpyProductAbstractEntityTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributesQuery;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductCategory\Persistence\SpyProductCategoryQuery;
use Orm\Zed\Url\Persistence\SpyUrlQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\DataImport\Business\Model\Writer\DataSettWriterInterface;
use Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventFacadeInterface;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductCategory\Dependency\ProductCategoryEvents;
use Spryker\Zed\Url\Dependency\UrlEvents;

class ProductAbstractPropelDataSettWriter extends DataImporterPublisher implements DataSettWriterInterface
{
    /**
     * @var \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository
     */
    protected $productRepository;

    /**
     * @param \Spryker\Zed\DataImport\Dependency\Facade\DataImportToEventFacadeInterface $eventFacade
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository $productRepository
     */
    public function __construct(
        DataImportToEventFacadeInterface $eventFacade,
        ProductRepository $productRepository
    ) {
        parent::__construct($eventFacade);
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $productAbstractEntity = $this->createOrUpdateProductAbstract($dataSet);

        $this->productRepository->addProductAbstract($productAbstractEntity);

        $this->createOrUpdateProductAbstractLocalizedAbstract($dataSet, $productAbstractEntity->getIdProductAbstract());
        $this->createOrUpdateProductCategories($dataSet, $productAbstractEntity->getIdProductAbstract());
        $this->createOrUpdateProductUrls($dataSet, $productAbstractEntity->getIdProductAbstract());

        $this->addEvent(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, $productAbstractEntity->getIdProductAbstract());
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
    protected function createOrUpdateProductAbstract(DataSetInterface $dataSet): SpyProductAbstract
    {
        $productAbstractEntityTransfer = $this->getProductAbstractTransfer($dataSet);

        $productAbstractEntity = SpyProductAbstractQuery::create()
            ->filterBySku($productAbstractEntityTransfer->getSku())
            ->findOneOrCreate();

        $productAbstractEntity->fromArray($productAbstractEntityTransfer->modifiedToArray());

        if ($productAbstractEntity->isNew() || $productAbstractEntity->isModified()) {
            $productAbstractEntity->save();

            $this->addEvent(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, $productAbstractEntity->getIdProductAbstract());
        }

        return $productAbstractEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function createOrUpdateProductAbstractLocalizedAbstract(DataSetInterface $dataSet, int $idProductAbstract): void
    {
        $productAbstractLocalizedTransfers = $this->getProductAbstractLocalizedTransfers($dataSet);

        foreach ($productAbstractLocalizedTransfers as $productAbstractLocalizedArray) {
            $productAbstractLocalizedTransfer = $productAbstractLocalizedArray[ProductAbstractHydratorStep::KEY_PRODUCT_ABSTRACT_LOCALIZED_TRANSFER];

            $idLocale = $productAbstractLocalizedTransfer->getFkLocale();

            $productAbstractLocalizedAttributesEntity = SpyProductAbstractLocalizedAttributesQuery::create()
                ->filterByFkProductAbstract($idProductAbstract)
                ->filterByFkLocale($idLocale)
                ->findOneOrCreate();

            $productAbstractLocalizedAttributesEntity->fromArray($productAbstractLocalizedTransfer->modifiedToArray());

            if ($productAbstractLocalizedAttributesEntity->isNew() || $productAbstractLocalizedAttributesEntity->isModified()) {
                $productAbstractLocalizedAttributesEntity->save();
            }
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function createOrUpdateProductCategories(DataSetInterface $dataSet, int $idProductAbstract): void
    {
        $productCategoryTransfers = $this->getProductCategoryTransfers($dataSet);

        foreach ($productCategoryTransfers as $productCategoryArray) {
            $productCategoryTransfer = $productCategoryArray[ProductAbstractHydratorStep::KEY_PRODUCT_CATEGORY_TRANSFER];

            $productCategoryEntity = SpyProductCategoryQuery::create()
                ->filterByFkProductAbstract($idProductAbstract)
                ->filterByFkCategory($productCategoryTransfer->getFkCategory())
                ->findOneOrCreate();

            $productCategoryEntity->fromArray($productCategoryTransfer->modifiedToArray());

            if ($productCategoryEntity->isNew() || $productCategoryEntity->isModified()) {
                $productCategoryEntity->save();

                $this->addEvent(ProductCategoryEvents::PRODUCT_CATEGORY_PUBLISH, $idProductAbstract);
                $this->addEvent(ProductEvents::PRODUCT_ABSTRACT_PUBLISH, $idProductAbstract);
            }
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function createOrUpdateProductUrls(DataSetInterface $dataSet, int $idProductAbstract): void
    {
        $productUrlTransfers = $this->getProductUrlTransfers($dataSet);

        foreach ($productUrlTransfers as $productUrlArray) {
            $productUrlTransfer = $productUrlArray[ProductAbstractHydratorStep::KEY_PRODUCT_URL_TRASNFER];

            $productUrl = $productUrlTransfer->getUrl();
            $idLocale = $productUrlTransfer->getFkLocale();

            $this->cleanupRedirectUrls($productUrl);

            $urlEntity = SpyUrlQuery::create()
                ->filterByFkLocale($idLocale)
                ->filterByFkResourceProductAbstract($idProductAbstract)
                ->findOneOrCreate();

            $urlEntity->fromArray($productUrlTransfer->modifiedToArray());

            if ($urlEntity->isNew() || $urlEntity->isModified()) {
                $urlEntity->save();

                $this->addEvent(UrlEvents::URL_PUBLISH, $urlEntity->getIdUrl());
            }
        }
    }

    /**
     * @param string $abstractProductUrl
     *
     * @return void
     */
    protected function cleanupRedirectUrls(string $abstractProductUrl): void
    {
        SpyUrlQuery::create()
            ->filterByUrl($abstractProductUrl)
            ->filterByFkResourceRedirect(null, Criteria::ISNOTNULL)
            ->delete();
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->triggerEvents();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductAbstractEntityTransfer
     */
    protected function getProductAbstractTransfer(DataSetInterface $dataSet): SpyProductAbstractEntityTransfer
    {
        return $dataSet[ProductAbstractHydratorStep::PRODUCT_ABSTRACT_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return array
     */
    protected function getProductAbstractLocalizedTransfers(DataSetInterface $dataSet): array
    {
        return $dataSet[ProductAbstractHydratorStep::PRODUCT_ABSTRACT_LOCALIZED_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return array
     */
    protected function getProductCategoryTransfers(DataSetInterface $dataSet): array
    {
        return $dataSet[ProductAbstractHydratorStep::PRODUCT_CATEGORY_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return array
     */
    protected function getProductUrlTransfers(DataSetInterface $dataSet): array
    {
        return $dataSet[ProductAbstractHydratorStep::PRODUCT_URL_TRANSFER];
    }
}
