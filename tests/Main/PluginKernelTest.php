<?php

namespace ACFFormatter\Tests\Main;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Main\PluginI18N;
use ACFCollector\Main\PluginKernel;
use ACFCollector\Main\PluginLoader;
use ACFCollector\Tests\ACFCollectorTestCase;

class PluginKernelTest extends ACFCollectorTestCase
{
    private function getPluginKernel(): PluginKernel
    {
        $pluginI18n = $this->getMockBuilder(PluginI18N::class)->getMock();
        $pluginLoader = $this->getMockBuilder(PluginLoader::class)->getMock();
        $acfHandler = ACFHandler::getInstance();
        $restAPIHandler = $this->getMockBuilder(RestAPIHandler::class)->setConstructorArgs([$pluginLoader, $acfHandler])->getMock();
        $templateHandler = $this->getMockBuilder(TemplateHandler::class)->setConstructorArgs([$pluginLoader, $acfHandler])->getMock();
        return new PluginKernel($pluginI18n, $restAPIHandler, $templateHandler, $pluginLoader);
    }

    public function testPluginVersion(): void
    {
        $pluginKernel = $this->getPluginKernel();
        $pluginKernel->init();

        $this->assertEquals(self::PLUGIN_VERSION, $pluginKernel->getVersion());
    }

    public function testPluginName(): void
    {
        $pluginKernel = $this->getPluginKernel();
        $pluginKernel->init();

        $this->assertEquals(self::PLUGIN_NAME, $pluginKernel->getPluginName());
    }

}