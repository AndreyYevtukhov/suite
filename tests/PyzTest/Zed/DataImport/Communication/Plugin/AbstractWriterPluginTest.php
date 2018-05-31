<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\DataImport\Communication\Plugin;

use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReaderConfigurationTransfer;
use Propel\Runtime\Propel;
use Pyz\Zed\DataImport\Business\DataImportBusinessFactory;
use Pyz\Zed\DataImport\DataImportConfig;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\DataImport\Business\Model\Writer\DataImportWriterCollection;
use Spryker\Zed\DataImport\Dependency\Propel\DataImportToPropelConnectionBridge;

/**
 * Auto-generated group annotations
 * @group PyzTest
 * @group Zed
 * @group DataImport
 * @group Communication
 * @group Plugin
 * @group AbstractWriterPluginTest
 * Add your own group annotations below this line
 */
abstract class AbstractWriterPluginTest extends Unit
{
    /**
     * @return array
     */
    abstract public function getDataImportWriterPlugins(): array;

    /**
     * @return string
     */
    abstract public function getDataImportCsvFile(): string;

    /**
     * @return object|\Pyz\Zed\DataImport\Business\DataImportBusinessFactory
     */
    protected function getDataImportBusinessFactoryStub()
    {
        return Stub::make(DataImportBusinessFactory::class, [
            'createProductAbstractDataImportWriters' => $this->createDataImportWriters(),
            'createProductConcreteDataImportWriters' => $this->createDataImportWriters(),
            'getConfig' => $this->getDataImportConfigStub(),
            'getPropelConnection' => $this->getPropelConnection(),
            'getStore' => $this->getStore(),
        ]);
    }

    /**
     * @return object|\Pyz\Zed\DataImport\DataImportConfig
     */
    public function getDataImportConfigStub()
    {
        return Stub::make(DataImportConfig::class, [
            'getProductAbstractDataImporterConfiguration' => $this->getDataImporterConfiguration(),
            'getProductConcreteDataImporterConfiguration' => $this->getDataImporterConfiguration(),
        ]);
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\Writer\DataImportWriterCollection
     */
    public function createDataImportWriters(): DataImportWriterCollection
    {
        return new DataImportWriterCollection($this->getDataImportWriterPlugins());
    }

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getDataImporterConfiguration(): DataImporterConfigurationTransfer
    {
        $dataImporterReaderConfigurationTransfer = new DataImporterReaderConfigurationTransfer();
        $dataImporterReaderConfigurationTransfer->setFileName(codecept_data_dir() . $this->getDataImportCsvFile());

        $dataImportConfigurationTransfer = new DataImporterConfigurationTransfer();
        $dataImportConfigurationTransfer->setReaderConfiguration($dataImporterReaderConfigurationTransfer);

        return $dataImportConfigurationTransfer;
    }

    /**
     * @return \Spryker\Zed\DataImport\Dependency\Propel\DataImportToPropelConnectionBridge
     */
    public function getPropelConnection(): DataImportToPropelConnectionBridge
    {
        return new DataImportToPropelConnectionBridge(Propel::getConnection());
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return Store::getInstance();
    }
}
