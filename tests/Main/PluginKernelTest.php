<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ACFFormatter\Tests\Main;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Main\PluginI18N;
use ACFCollector\Main\PluginKernel;
use ACFCollector\Main\PluginLoader;
use ACFCollector\Main\PluginOptions;
use ACFCollector\Tests\ACFCollectorTestCase;

class PluginKernelTest extends ACFCollectorTestCase
{
    private function getPluginKernel(): PluginKernel
    {
        $pluginI18n = $this->getMockBuilder(PluginI18N::class)->getMock();
        $pluginLoader = $this->getMockBuilder(PluginLoader::class)->getMock();
        $acfHandler = ACFHandler::getInstance();
        $restAPIHandler = $this->getMockBuilder(RestAPIHandler::class)->setConstructorArgs([$pluginLoader, $acfHandler, $this->getACFCollectorFieldName()])->getMock();
        $templateHandler = $this->getMockBuilder(TemplateHandler::class)->setConstructorArgs([$pluginLoader, $acfHandler, $this->getACFCollectorFieldName()])->getMock();
        $pluginOptions = $this->getMockBuilder(PluginOptions::class)->getMock();
        return new PluginKernel($pluginI18n, $restAPIHandler, $templateHandler, $pluginLoader, $pluginOptions);
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