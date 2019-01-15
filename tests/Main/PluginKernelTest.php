<?php

namespace ACFFormatter\Tests\Main;

use ACFFormatter\Handler\RestAPIHandler;
use ACFFormatter\Handler\TemplateHandler;
use ACFFormatter\Main\PluginI18N;
use ACFFormatter\Main\PluginKernel;
use ACFFormatter\Main\PluginLoader;
use ACFFormatter\Tests\ACFFormatterTestCase;

class PluginKernelTest extends ACFFormatterTestCase
{
    private function getPluginKernel(): PluginKernel
    {
        $pluginI18n = $this->getMockBuilder(PluginI18N::class)->getMock();
        $pluginLoader = $this->getMockBuilder(PluginLoader::class)->getMock();
        $restAPIHandler = $this->getMockBuilder(RestAPIHandler::class)->setConstructorArgs([$pluginLoader])->getMock();
        $templateHandler = $this->getMockBuilder(TemplateHandler::class)->setConstructorArgs([$pluginLoader])->getMock();
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