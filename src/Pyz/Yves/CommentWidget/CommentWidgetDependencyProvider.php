<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CommentWidget;

use SprykerShop\Yves\CartPage\Plugin\CommentWidget\CartCommentThreadAfterOperationStrategyPlugin;
use SprykerShop\Yves\CommentWidget\CommentWidgetDependencyProvider as SprykerShopCommentDependencyProvider;

class CommentWidgetDependencyProvider extends SprykerShopCommentDependencyProvider
{
    /**
     * @return \SprykerShop\Yves\CommentWidgetExtension\Dependency\Plugin\CommentThreadAfterOperationStrategyPluginInterface[]
     */
    protected function getCommentThreadAfterOperationPlugins(): array
    {
        return [
            new CartCommentThreadAfterOperationStrategyPlugin(),
        ];
    }
}
