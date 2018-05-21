<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Communication\Plugin\ProductAbstractStore;

use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportFlushPluginInterface;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportWriterPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\DataImport\Business\DataImportFacadeInterface getFacade()
 */
class ProductAbstractStorePropelWriterPlugin extends AbstractPlugin implements DataImportWriterPluginInterface, DataImportFlushPluginInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $this->getFacade()->writeProductAbstractStoreDataSet($dataSet);
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->getFacade()->flushProductAbstractStoreDataImporter();
    }
}
