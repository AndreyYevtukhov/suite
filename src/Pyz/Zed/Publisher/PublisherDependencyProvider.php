<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Publisher;

use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Shared\PublishAndSynchronizeHealthCheck\PublishAndSynchronizeHealthCheckConfig;
use Spryker\Zed\AssetStorage\Communication\Plugin\Publisher\Asset\AssetDeletePublisherPlugin;
use Spryker\Zed\AssetStorage\Communication\Plugin\Publisher\Asset\AssetWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\Category\CategoryDeletePublisherPlugin as CategoryPageSearchCategoryDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as CategoryPageSearchCategoryWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeDeletePublisherPlugin as CategoryPageSearchCategoryAttributeDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin as CategoryPageSearchCategoryAttributeWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryNode\CategoryNodeDeletePublisherPlugin as CategoryPageSearchCategoryNodeDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin as CategoryPageSearchCategoryNodeWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryPagePublisherTriggerPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWriteForPublishingPublisherPlugin as CategoryStoreSearchWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWritePublisherPlugin as CategoryStoreSearchWritePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateDeletePublisherPlugin as CategoryPageSearchCategoryTemplateDeletePublisherPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateWritePublisherPlugin as CategoryPageSearchCategoryTemplateWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\Category\CategoryDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as CategoryStoreCategoryWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryNodePublisherTriggerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWriteForPublishingPublisherPlugin as CategoryStoreStorageWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryStore\CategoryStoreWritePublisherPlugin as CategoryStoreStorageWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTemplate\CategoryTemplateWritePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTree\CategoryTreeDeletePublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTree\CategoryTreeWriteForPublishingPublisherPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\CategoryTreePublisherTriggerPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Publisher\ParentWritePublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryDeletePublisherPlugin as GlossaryKeyDeletePublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryWritePublisherPlugin as GlossaryKeyWriterPublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryPublisherTriggerPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryTranslation\GlossaryWritePublisherPlugin as GlossaryTranslationWritePublisherPlugin;
use Spryker\Zed\MerchantCategory\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin;
use Spryker\Zed\MerchantOpeningHoursStorage\Communication\Plugin\Publisher\MerchantOpeningHours\MerchantOpeningHoursWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferSearch\Communication\Plugin\Publisher\ProductOffer\ProductConcreteWritePublisherPlugin as ProductOfferProductConcreteWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferSearch\Communication\Plugin\Publisher\ProductOfferStore\ProductConcreteWritePublisherPlugin as ProductOfferStoreProductConcreteWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferStorage\Communication\Plugin\Publisher\Merchant\MerchantProductOfferWritePublisherPlugin;
use Spryker\Zed\MerchantProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteProductOffer\MerchantProductConcreteProductOfferWritePublisherPlugin;
use Spryker\Zed\MerchantProductOptionStorage\Communication\Plugin\Publisher\MerchantProductOption\MerchantProductOptionGroupWritePublisherPlugin;
use Spryker\Zed\MerchantProductSearch\Communication\Plugin\Publisher\Merchant\MerchantProductSearchWritePublisherPlugin as MerchantMerchantProductSearchWritePublisherPlugin;
use Spryker\Zed\MerchantProductSearch\Communication\Plugin\Publisher\MerchantProduct\MerchantProductSearchWritePublisherPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\Publisher\Merchant\MerchantUpdatePublisherPlugin;
use Spryker\Zed\MerchantProductStorage\Communication\Plugin\Publisher\MerchantProduct\MerchantProductWritePublisherPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\Merchant\MerchantDeletePublisherPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\Merchant\MerchantWritePublisherPlugin;
use Spryker\Zed\MerchantSearch\Communication\Plugin\Publisher\MerchantCategory\MerchantCategoryWritePublisherPlugin;
use Spryker\Zed\MerchantStorage\Communication\Plugin\Publisher\Merchant\MerchantCategoryStoragePublisherPlugin;
use Spryker\Zed\MerchantStorage\Communication\Plugin\Publisher\Merchant\MerchantStoragePublisherPlugin;
use Spryker\Zed\MerchantStorage\Communication\Plugin\Publisher\MerchantPublisherTriggerPlugin;
use Spryker\Zed\PriceProductMerchantRelationshipStorage\Communication\Plugin\Publisher\Merchant\MerchantWritePublisherPlugin as PriceProductMerchantWritePublisherPlugin;
use Spryker\Zed\PriceProductOfferStorage\Communication\Plugin\Publisher\PriceProductOffer\PriceProductStoreWritePublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductAbstractUpdatedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteCreatedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteDeletedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteExportedMessageBrokerPublisherPlugin;
use Spryker\Zed\Product\Communication\Plugin\Publisher\ProductConcreteUpdatedMessageBrokerPublisherPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle\ProductBundlePublishWritePublisherPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundle\ProductBundleWritePublisherPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductBundlePublisherTriggerPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Publisher\ProductConcrete\ProductBundleWritePublisherPlugin as ProductConcreteProductBundleWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryIsActiveAndCategoryKeyWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreDeletePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryStoreWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\Category\CategoryWritePublisherPlugin as ProductCategoryStorageCategoryWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeNameWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryAttribute\CategoryAttributeWritePublisherPlugin as ProductCategoryAttributeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryNode\CategoryNodeWritePublisherPlugin as ProductCategoryNodeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryUrl\CategoryUrlAndResourceCategorynodeWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\CategoryUrl\CategoryUrlWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategory\ProductCategoryWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategory\ProductCategoryWritePublisherPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Publisher\ProductCategoryPublisherTriggerPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfiguration\ProductConfigurationDeletePublisherPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfiguration\ProductConfigurationWritePublisherPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Publisher\ProductConfigurationPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabel\ProductLabelWritePublisherPlugin as ProductLabelSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelStore\ProductLabelStoreWritePublisherPlugin as ProductLabelStoreSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabel\ProductAbstractLabelWritePublisherPlugin as ProductAbstractLabelStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabelPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryDeletePublisherPlugin as ProductLabelDictionaryStorageDeletePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryWritePublisherPlugin as ProductLabelDictionaryStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionaryPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractStorageWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersStoreDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductConcreteOffers\ProductConcreteProductOffersWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferStoreDeletePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferStoreWritePublisherPlugin;
use Spryker\Zed\ProductOfferStorage\Communication\Plugin\Publisher\ProductOffer\ProductOfferWritePublisherPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Publisher\Product\ProductConcretePageSearchWritePublisherPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Publisher\ProductConcretePublisherTriggerPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationProductAbstract\ProductRelationProductAbstractWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationPublisherTriggerPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationStore\ProductRelationStoreWritePublisherPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckSearch\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckSearchWritePublisherPlugin;
use Spryker\Zed\PublishAndSynchronizeHealthCheckStorage\Communication\Plugin\Publisher\PublishAndSynchronizeHealthCheckStorageWritePublisherPlugin;
use Spryker\Zed\Publisher\PublisherDependencyProvider as SprykerPublisherDependencyProvider;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonDeletePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonWritePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReasonPublisherTriggerPlugin;

class PublisherDependencyProvider extends SprykerPublisherDependencyProvider
{
    /**
     * @return array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>|array<string, array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>>
     */
    protected function getPublisherPlugins(): array
    {
        return array_merge(
            $this->getPublishAndSynchronizeHealthCheckPlugins(),
            $this->getGlossaryStoragePlugins(),
            $this->getProductRelationStoragePlugins(),
            $this->getProductLabelStoragePlugins(),
            $this->getProductLabelSearchPlugins(),
            $this->getProductRelationStoragePlugins(),
            $this->getMerchantStoragePlugins(),
            $this->getReturnReasonSearchPlugins(),
            $this->getMerchantCategoryPlugins(),
            $this->getMerchantProductPlugins(),
            $this->getMerchantProductSearchPlugins(),
            $this->getProductBundleStoragePlugins(),
            $this->getMerchantProductSearchPlugins(),
            $this->getProductConfigurationStoragePlugins(),
            $this->getMerchantSearchPlugins(),
            $this->getCategoryStoragePlugins(),
            $this->getCategoryPageSearchPlugins(),
            $this->getProductPageSearchPlugins(),
            $this->getProductCategoryStoragePlugins(),
            $this->getMerchantOpeningHoursStoragePlugins(),
            $this->getMerchantProductOptionStoragePlugins(),
            $this->getPriceProductOfferStoragePlugins(),
            $this->getPriceProductMerchantRelationshipStoragePlugins(),
            $this->getProductOfferStoragePlugins(),
            $this->getMerchantProductOfferStoragePlugins(),
            $this->getMerchantProductOfferSearchPlugins(),
            $this->getAssetStoragePlugins(),
            $this->getProductExportPlugins(),
        );
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherTriggerPluginInterface>
     */
    protected function getPublisherTriggerPlugins(): array
    {
        return [
            new GlossaryPublisherTriggerPlugin(),
            new ProductRelationPublisherTriggerPlugin(),
            new ProductAbstractLabelPublisherTriggerPlugin(),
            new ProductLabelDictionaryPublisherTriggerPlugin(),
            new MerchantPublisherTriggerPlugin(),
            new ReturnReasonPublisherTriggerPlugin(),
            new ProductBundlePublisherTriggerPlugin(),
            new ProductConfigurationPublisherTriggerPlugin(),
            new CategoryNodePublisherTriggerPlugin(),
            new CategoryTreePublisherTriggerPlugin(),
            new ProductCategoryPublisherTriggerPlugin(),
            new CategoryPagePublisherTriggerPlugin(),
            new ProductConcretePublisherTriggerPlugin(),
        ];
    }

    /**
     * @return array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>|array<string, array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>>
     */
    protected function getGlossaryStoragePlugins(): array
    {
        return [
            GlossaryStorageConfig::PUBLISH_TRANSLATION => [
                new GlossaryKeyDeletePublisherPlugin(),
                new GlossaryKeyWriterPublisherPlugin(),
                new GlossaryTranslationWritePublisherPlugin(),
            ],
        ];
    }

    /**
     * @return array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>|array<string, array<int|string, \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>>
     */
    protected function getPublishAndSynchronizeHealthCheckPlugins(): array
    {
        return [
            PublishAndSynchronizeHealthCheckConfig::PUBLISH_PUBLISH_AND_SYNCHRONIZE_HEALTH_CHECK => [
                new PublishAndSynchronizeHealthCheckStorageWritePublisherPlugin(),
                new PublishAndSynchronizeHealthCheckSearchWritePublisherPlugin(),
            ],
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductRelationStoragePlugins(): array
    {
        return [
            new ProductRelationWritePublisherPlugin(),
            new ProductRelationWriteForPublishingPublisherPlugin(),
            new ProductRelationProductAbstractWritePublisherPlugin(),
            new ProductRelationStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductLabelStoragePlugins(): array
    {
        return [
            new ProductAbstractLabelStorageWritePublisherPlugin(),
            new ProductLabelProductAbstractStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductLabelSearchPlugins(): array
    {
        return [
            new ProductLabelSearchWritePublisherPlugin(),
            new ProductLabelProductAbstractSearchWritePublisherPlugin(),
            new ProductLabelStoreSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantCategoryPlugins(): array
    {
        return [
            new CategoryWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantStoragePlugins(): array
    {
        return [
            new MerchantCategoryStoragePublisherPlugin(),
            new MerchantStoragePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantSearchPlugins(): array
    {
        return [
           new MerchantWritePublisherPlugin(),
           new MerchantCategoryWritePublisherPlugin(),
           new MerchantDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getReturnReasonSearchPlugins(): array
    {
        return [
            new ReturnReasonWritePublisherPlugin(),
            new ReturnReasonDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductPlugins(): array
    {
        return [
            new MerchantProductWritePublisherPlugin(),
            new MerchantUpdatePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductSearchPlugins(): array
    {
        return [
            new MerchantMerchantProductSearchWritePublisherPlugin(),
            new MerchantProductSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductBundleStoragePlugins(): array
    {
        return [
            new ProductBundlePublishWritePublisherPlugin(),
            new ProductBundleWritePublisherPlugin(),
            new ProductConcreteProductBundleWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductConfigurationStoragePlugins(): array
    {
        return [
            new ProductConfigurationWritePublisherPlugin(),
            new ProductConfigurationDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getCategoryStoragePlugins(): array
    {
        return [
            new CategoryStoreStorageWritePublisherPlugin(),
            new CategoryStoreStorageWriteForPublishingPublisherPlugin(),
            new CategoryTreeWriteForPublishingPublisherPlugin(),
            new CategoryDeletePublisherPlugin(),
            new CategoryStoreCategoryWritePublisherPlugin(),
            new CategoryAttributeDeletePublisherPlugin(),
            new CategoryAttributeWritePublisherPlugin(),
            new CategoryNodeDeletePublisherPlugin(),
            new CategoryNodeWritePublisherPlugin(),
            new CategoryTemplateDeletePublisherPlugin(),
            new CategoryTemplateWritePublisherPlugin(),
            new CategoryTreeDeletePublisherPlugin(),
            new ParentWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getCategoryPageSearchPlugins(): array
    {
        return [
            new CategoryStoreSearchWritePublisherPlugin(),
            new CategoryStoreSearchWriteForPublishingPublisherPlugin(),
            new CategoryPageSearchCategoryDeletePublisherPlugin(),
            new CategoryPageSearchCategoryWritePublisherPlugin(),
            new CategoryPageSearchCategoryAttributeDeletePublisherPlugin(),
            new CategoryPageSearchCategoryAttributeWritePublisherPlugin(),
            new CategoryPageSearchCategoryNodeDeletePublisherPlugin(),
            new CategoryPageSearchCategoryNodeWritePublisherPlugin(),
            new CategoryPageSearchCategoryTemplateDeletePublisherPlugin(),
            new CategoryPageSearchCategoryTemplateWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductPageSearchPlugins(): array
    {
        return [
            new ProductConcretePageSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductCategoryStoragePlugins(): array
    {
        return [
            new CategoryStoreWritePublisherPlugin(),
            new CategoryStoreWriteForPublishingPublisherPlugin(),
            new CategoryStoreDeletePublisherPlugin(),
            new ProductCategoryStorageCategoryWritePublisherPlugin(),
            new CategoryIsActiveAndCategoryKeyWritePublisherPlugin(),
            new ProductCategoryAttributeWritePublisherPlugin(),
            new CategoryAttributeNameWritePublisherPlugin(),
            new ProductCategoryNodeWritePublisherPlugin(),
            new CategoryUrlWritePublisherPlugin(),
            new CategoryUrlAndResourceCategorynodeWritePublisherPlugin(),
            new ProductCategoryWriteForPublishingPublisherPlugin(),
            new ProductCategoryWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantOpeningHoursStoragePlugins(): array
    {
        return [
            new MerchantOpeningHoursWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductOptionStoragePlugins(): array
    {
        return [
            new MerchantProductOptionGroupWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getPriceProductOfferStoragePlugins(): array
    {
        return [
            new PriceProductStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getPriceProductMerchantRelationshipStoragePlugins(): array
    {
        return [
            new PriceProductMerchantWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductOfferStoragePlugins(): array
    {
        return [
            new ProductConcreteProductOffersDeletePublisherPlugin(),
            new ProductConcreteProductOffersWritePublisherPlugin(),
            new ProductOfferDeletePublisherPlugin(),
            new ProductOfferWritePublisherPlugin(),
            new ProductOfferStoreWritePublisherPlugin(),
            new ProductOfferStoreDeletePublisherPlugin(),
            new ProductConcreteProductOffersStoreWritePublisherPlugin(),
            new ProductConcreteProductOffersStoreDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductOfferStoragePlugins(): array
    {
        return [
            new MerchantProductConcreteProductOfferWritePublisherPlugin(),
            new MerchantProductOfferWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getMerchantProductOfferSearchPlugins(): array
    {
        return [
            new ProductOfferProductConcreteWritePublisherPlugin(),
            new ProductOfferStoreProductConcreteWritePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getAssetStoragePlugins(): array
    {
        return [
            new AssetWritePublisherPlugin(),
            new AssetDeletePublisherPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface>
     */
    protected function getProductExportPlugins(): array
    {
        return [
            new ProductConcreteExportedMessageBrokerPublisherPlugin(),
            new ProductConcreteCreatedMessageBrokerPublisherPlugin(),
            new ProductConcreteUpdatedMessageBrokerPublisherPlugin(),
            new ProductConcreteDeletedMessageBrokerPublisherPlugin(),
            new ProductAbstractUpdatedMessageBrokerPublisherPlugin(),
        ];
    }
}
