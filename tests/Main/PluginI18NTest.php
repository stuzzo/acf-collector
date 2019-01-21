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