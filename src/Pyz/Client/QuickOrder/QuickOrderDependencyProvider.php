<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\QuickOrder;

use Spryker\Client\ProductMeasurementUnitStorage\Plugin\ProductConcreteTransferBaseMeasurementUnitExpanderPlugin;
use Spryker\Client\ProductQuantityStorage\Plugin\ProductConcreteQuantityRestrictionsExpanderPlugin;
use Spryker\Client\QuickOrder\QuickOrderDependencyProvider as SprykerQuickOrderDependencyProvider;

class QuickOrderDependencyProvider extends SprykerQuickOrderDependencyProvider
{
    /**
     * @return \Spryker\Client\QuickOrderExtension\Dependency\Plugin\ProductConcreteExpanderPluginInterface[]
     */
    protected function getProductConcreteExpanderPlugins(): array
    {
        return [
            new ProductConcreteTransferBaseMeasurementUnitExpanderPlugin(),
            new ProductConcreteQuantityRestrictionsExpanderPlugin(),
        ];
    }
}
