<?php

namespace ACFFormatter\Tests\Main;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Main\PluginLoader;
use ACFCollector\Tests\ACFCollectorTestCase;
use function has_filter;

class PluginLoaderTest extends ACFCollectorTestCase
{
    private function getPluginLoader(): PluginLoader
    {
        return new PluginLoader();
    }

    public function testAddFilter(): void
    {
        $pluginLoader = $this->getPluginLoader();

        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        $templateHandler->init();

        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'register_template_hook']));
    }

    public function testAddAction(): void
    {
        $pluginLoader = $this->getPluginLoader();

        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance());
        $templateHandler->init();

        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'register_template_hook']));
    }

}