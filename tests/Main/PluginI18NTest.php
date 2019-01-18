<?php

namespace ACFFormatter\Tests\Main;

use ACFCollector\Handler\RestAPIHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Main\PluginI18N;
use ACFCollector\Main\PluginKernel;
use ACFCollector\Main\PluginLoader;
use ACFCollector\Tests\ACFCollectorTestCase;

class PluginI18NTest extends ACFCollectorTestCase
{
    public function testIfLoadDomainIsCalled(): void
    {
        $pluginI18n = $this->getMockBuilder(PluginI18N::class)->getMock();
        $pluginI18n->expects($this->once())->method('loadPluginTextdomain');
        $pluginI18n->loadPluginTextDomain();
    }

}