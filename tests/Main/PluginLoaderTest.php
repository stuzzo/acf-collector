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
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Tests\ACFCollectorTestCase;
use function has_filter;

class PluginLoaderTest extends ACFCollectorTestCase
{

    public function testAddFilter(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        $templateHandler->init();
        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentPost']));
        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentTaxonomy']));
    }

}