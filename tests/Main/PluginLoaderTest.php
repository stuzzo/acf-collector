<?php

namespace ACFFormatter\Tests\Main;

use ACFFormatter\Handler\TemplateHandler;
use ACFFormatter\Main\PluginLoader;
use ACFFormatter\Tests\ACFFormatterTestCase;
use function has_filter;

class PluginLoaderTest extends ACFFormatterTestCase
{
    private function getPluginLoader(): PluginLoader
    {
        return new PluginLoader();
    }

    public function testAddFilter(): void
    {
        $pluginLoader = $this->getPluginLoader();

        $templateHandler = new TemplateHandler($pluginLoader);
        $templateHandler->init();

        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'register_template_hook']));
    }

}