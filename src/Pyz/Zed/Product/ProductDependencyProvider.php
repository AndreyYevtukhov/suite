<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Product;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantProduct\Communication\Plugin\Product\MerchantProductProductAbstractPostCreatePlugin;
use Spryker\Zed\MerchantProductApproval\Communication\Plugin\Product\MerchantProductApprovalProductAbstractPreCreatePlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\Product\PriceProductAbstractPostCreatePlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\Product\PriceProductProductAbstractExpanderPlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\Product\PriceProductProductConcreteExpanderPlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\ProductAbstract\PriceProductAbstractAfterUpdatePlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\ProductConcrete\PriceProductConcreteAfterCreatePlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\ProductConcrete\PriceProductConcreteAfterUpdatePlugin;
use Spryker\Zed\Product\ProductDependencyProvider as SprykerProductDependencyProvider;
use Spryker\Zed\ProductAlternativeGui\Communication\Plugin\Product\ProductConcretePluginUpdate as ProductAlternativeGuiProductConcretePluginUpdate;
use Spryker\Zed\ProductApproval\Communication\Plugin\Product\ProductApprovalProductAbstractPreCreatePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Product\ProductBundleDeactivatorProductConcreteAfterUpdatePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Product\ProductBundleProductConcreteAfterCreatePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Product\ProductBundleProductConcreteAfterUpdatePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Product\ProductBundleProductConcreteExpanderPlugin;
use Spryker\Zed\ProductDiscontinued\Communication\Plugin\SaveDiscontinuedNotesProductConcretePluginUpdate;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\Product\DiscontinuedProductConcreteAfterCreatePlugin;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\Product\DiscontinuedProductConcreteAfterUpdatePlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\Product\ImageSetProductAbstractPostCreatePlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\Product\ProductImageProductAbstractExpanderPlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\Product\ProductImageProductConcreteExpanderPlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\ProductAbstractAfterUpdatePlugin as ImageSetProductAbstractAfterUpdatePlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\ProductConcreteAfterCreatePlugin as ImageSetProductConcreteAfterCreatePlugin;
use Spryker\Zed\ProductImage\Communication\Plugin\ProductConcreteAfterUpdatePlugin as ImageSetProductConcreteAfterUpdatePlugin;
use Spryker\Zed\ProductSearch\Communication\Plugin\Product\ProductSearchProductConcreteExpanderPlugin;
use Spryker\Zed\ProductSearch\Communication\Plugin\ProductConcrete\ProductSearchProductConcreteAfterCreatePlugin;
use Spryker\Zed\ProductSearch\Communication\Plugin\ProductConcrete\ProductSearchProductConcreteAfterUpdatePlugin;
use Spryker\Zed\ProductValidity\Communication\Plugin\Product\ProductValidityProductConcreteExpanderPlugin;
use Spryker\Zed\ProductValidity\Communication\Plugin\ProductValidityCreatePlugin;
use Spryker\Zed\ProductValidity\Communication\Plugin\ProductValidityUpdatePlugin;
use Spryker\Zed\Stock\Communication\Plugin\Product\StockProductConcreteExpanderPlugin;
use Spryker\Zed\Stock\Communication\Plugin\ProductConcreteAfterCreatePlugin as StockProductConcreteAfterCreatePlugin;
use Spryker\Zed\Stock\Communication\Plugin\ProductConcreteAfterUpdatePlugin as StockProductConcreteAfterUpdatePlugin;
use Spryker\Zed\TaxProductConnector\Communication\Plugin\Product\TaxSetProductAbstractExpanderPlugin;
use Spryker\Zed\TaxProductConnector\Communication\Plugin\Product\TaxSetProductAbstractPostCreatePlugin;
use Spryker\Zed\TaxProductConnector\Communication\Plugin\TaxSetProductAbstractAfterUpdatePlugin;

class ProductDependencyProvider extends SprykerProductDependencyProvider
{
    /**
     * The order of execution is important to support Inherited scope and sub-entity functionality
     *
     * @return array<\Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPostCreatePluginInterface>
     */
    protected function getProductAbstractPostCreatePlugins(): array
    {
        return [
            new MerchantProductProductAbstractPostCreatePlugin(),
            new ImageSetProductAbstractPostCreatePlugin(),
            new TaxSetProductAbstractPostCreatePlugin(),
            new PriceProductAbstractPostCreatePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractExpanderPluginInterface>
     */
    protected function getProductAbstractExpanderPlugins(Container $container): array
    {
        return [
            new ProductImageProductAbstractExpanderPlugin(),
            new TaxSetProductAbstractExpanderPlugin(),
            new PriceProductProductAbstractExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface>
     */
    protected function getProductAbstractBeforeUpdatePlugins(Container $container): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface>
     */
    protected function getProductAbstractAfterUpdatePlugins(Container $container): array
    {
        return [
            new ImageSetProductAbstractAfterUpdatePlugin(),
            new TaxSetProductAbstractAfterUpdatePlugin(),
            new PriceProductAbstractAfterUpdatePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteCreatePluginInterface>
     */
    protected function getProductConcreteAfterCreatePlugins(Container $container): array
    {
        return [
            new ImageSetProductConcreteAfterCreatePlugin(),
            new StockProductConcreteAfterCreatePlugin(),
            new PriceProductConcreteAfterCreatePlugin(),
            new ProductSearchProductConcreteAfterCreatePlugin(),
            new ProductBundleProductConcreteAfterCreatePlugin(),
            new ProductValidityCreatePlugin(),
            new DiscontinuedProductConcreteAfterCreatePlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginReadInterface>
     */
    protected function getProductConcreteReadPlugins(Container $container): array
    {
        return [
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface>
     */
    protected function getProductConcreteBeforeUpdatePlugins(Container $container): array
    {
        return [
            new ProductAlternativeGuiProductConcretePluginUpdate(), #ProductAlternativeFeature
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array<\Spryker\Zed\Product\Dependency\Plugin\ProductConcretePluginUpdateInterface>
     */
    protected function getProductConcreteAfterUpdatePlugins(Container $container): array
    {
        return [
            new ImageSetProductConcreteAfterUpdatePlugin(),
            new StockProductConcreteAfterUpdatePlugin(),
            new PriceProductConcreteAfterUpdatePlugin(),
            new ProductSearchProductConcreteAfterUpdatePlugin(),
            new ProductBundleProductConcreteAfterUpdatePlugin(),
            new ProductValidityUpdatePlugin(),
            new SaveDiscontinuedNotesProductConcretePluginUpdate(),
            new DiscontinuedProductConcreteAfterUpdatePlugin(),
            new ProductBundleDeactivatorProductConcreteAfterUpdatePlugin(),
        ];
    }

    /**
     * The order of execution is important for expanding with correct product approval statuses.
     *
     * @return array<\Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPreCreatePluginInterface>
     */
    protected function getProductAbstractPreCreatePlugins(): array
    {
        return [
            new MerchantProductApprovalProductAbstractPreCreatePlugin(),
            new ProductApprovalProductAbstractPreCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\ProductExtension\Dependency\Plugin\ProductConcreteExpanderPluginInterface>
     */
    protected function getProductConcreteExpanderPlugins(): array
    {
        return [
            new ProductImageProductConcreteExpanderPlugin(),
            new StockProductConcreteExpanderPlugin(),
            new PriceProductProductConcreteExpanderPlugin(),
            new ProductSearchProductConcreteExpanderPlugin(),
            new ProductBundleProductConcreteExpanderPlugin(),
            new ProductValidityProductConcreteExpanderPlugin(),
        ];
    }
}
