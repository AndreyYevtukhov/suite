<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductImage\Writer;

use Generated\Shared\Transfer\SpyProductImageSetEntityTransfer;
use Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer;
use Orm\Zed\ProductImage\Persistence\SpyProductImage;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSet;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetQuery;
use Orm\Zed\ProductImage\Persistence\SpyProductImageSetToProductImage;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\ProductImage\Dependency\ProductImageEvents;

class ProductImagePropelDataSetWriter implements DataSetWriterInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $productImageSetEntity = $this->createOrUpdateProductImageSet($dataSet);
        $productImageEntity = $this->createProductImage($dataSet);
        $this->createImageToImageSetRelation($productImageSetEntity, $productImageEntity, $dataSet);
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        DataImporterPublisher::triggerEvents();
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImageSet
     */
    protected function createOrUpdateProductImageSet(DataSetInterface $dataSet): SpyProductImageSet
    {
        $productImageSetEntityTransfer = $this->getProductImageSetTransfer($dataSet);
        $idLocale = $productImageSetEntityTransfer->getFkLocale();

        $query = SpyProductImageSetQuery::create()
            ->filterByName($productImageSetEntityTransfer->getName())
            ->filterByFkLocale($idLocale);

        if (!empty($dataSet[ProductImageHydratorStep::KEY_ABSTRACT_SKU])) {
            $query->filterByFkProductAbstract($productImageSetEntityTransfer->getFkProductAbstract());
        }

        if (!empty($dataSet[ProductImageHydratorStep::KEY_CONCRETE_SKU])) {
            $query->filterByFkProduct($productImageSetEntityTransfer->getFkProduct());
        }

        $productImageSetEntity = $query->findOneOrCreate();
        if ($productImageSetEntity->isNew() || $productImageSetEntity->isModified()) {
            $productImageSetEntity->save();
        }

        return $productImageSetEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImage
     */
    protected function createProductImage(DataSetInterface $dataSet): SpyProductImage
    {
        $productImageEntity = $this->getProductImageEntityFromDataSet($dataSet);
        $productImageEntity->save();

        return $productImageEntity;
    }

    /**
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImageSet $productImageSetEntity
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImage $productImageEntity
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function createImageToImageSetRelation(
        SpyProductImageSet $productImageSetEntity,
        SpyProductImage $productImageEntity,
        DataSetInterface $dataSet
    ): void {
        $productImageSetToProductImageEntity = new SpyProductImageSetToProductImage();
        $productImageSetToProductImageEntity->setFkProductImageSet($productImageSetEntity->getIdProductImageSet());
        $productImageSetToProductImageEntity->setFkProductImage($productImageEntity->getIdProductImage());
        $productImageToImageSetRelationTransfer = $this->getProductImageToImageSetRelationTransfer($dataSet);
        $productImageSetToProductImageEntity->setSortOrder($productImageToImageSetRelationTransfer->getSortOrder());

        $productImageSetToProductImageEntity->save();

        $this->addImagePublishEvents($productImageSetEntity);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\ProductImage\Persistence\SpyProductImage
     */
    protected function getProductImageEntityFromDataSet(DataSetInterface $dataSet): SpyProductImage
    {
        /** @var \Generated\Shared\Transfer\SpyProductImageEntityTransfer $productImageEntityTransfer */
        $productImageEntityTransfer = $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TRANSFER];
        $productImageEntity = new SpyProductImage();
        $productImageEntity->fromArray(
            $productImageEntityTransfer->modifiedToArray()
        );

        return $productImageEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductImageSetEntityTransfer
     */
    protected function getProductImageSetTransfer(DataSetInterface $dataSet): SpyProductImageSetEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_SET_TRANSFER];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Generated\Shared\Transfer\SpyProductImageSetToProductImageEntityTransfer
     */
    protected function getProductImageToImageSetRelationTransfer(DataSetInterface $dataSet): SpyProductImageSetToProductImageEntityTransfer
    {
        return $dataSet[ProductImageHydratorStep::DATA_PRODUCT_IMAGE_TO_IMAGE_SET_RELATION_TRANSFER];
    }

    /**
     * @param \Orm\Zed\ProductImage\Persistence\SpyProductImageSet $productImageSetEntity
     *
     * @return void
     */
    protected function addImagePublishEvents(SpyProductImageSet $productImageSetEntity): void
    {
        if ($productImageSetEntity->getFkProductAbstract()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract()
            );
            DataImporterPublisher::addEvent(
                ProductEvents::PRODUCT_ABSTRACT_PUBLISH,
                $productImageSetEntity->getFkProductAbstract()
            );
        } elseif ($productImageSetEntity->getFkProduct()) {
            DataImporterPublisher::addEvent(
                ProductImageEvents::PRODUCT_IMAGE_PRODUCT_CONCRETE_PUBLISH,
                $productImageSetEntity->getFkProduct()
            );
        }
    }
}
