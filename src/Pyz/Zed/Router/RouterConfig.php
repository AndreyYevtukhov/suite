<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Router;

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Zed\Router\RouterConfig as SprykerRouterConfig;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToDash;

class RouterConfig extends SprykerRouterConfig
{
    /**
     * @project Only required for nonsplit-repositories, do not use this in project.
     *
     * @return string[]
     */
    public function getControllerDirectories(): array
    {
        $controllerDirectories = [];

        foreach ($this->get(KernelConstants::PROJECT_NAMESPACES) as $projectNamespace) {
            $controllerDirectories[] = sprintf('%s/%s/Zed/*/Communication/Controller/', APPLICATION_SOURCE_DIR, $projectNamespace);
        }

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        foreach ($this->get(KernelConstants::CORE_NAMESPACES) as $coreNamespace) {
            $controllerDirectories[] = sprintf('%s/spryker/%s/Bundles/*/src/%s/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR, $filterChain->filter($coreNamespace), $coreNamespace);
        }

        $controllerDirectories[] = sprintf('%s/spryker-sdk/*/src/*/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR);
        $controllerDirectories[] = sprintf('%s/spryker-eco/*/src/*/Zed/*/Communication/Controller/', APPLICATION_VENDOR_DIR);

        return array_filter($controllerDirectories, 'glob');
    }
}
