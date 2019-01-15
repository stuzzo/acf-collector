<?php

namespace ACFFormatter\Tests\Main;

use ACFFormatter\Main\PluginLoader;
use ACFFormatter\Tests\ACFFormatterTestCase;

class PluginLoaderTest extends ACFFormatterTestCase
{
    private function getPluginLoader(): PluginLoader
    {
        return new PluginLoader();
    }

    private function getActionConfig(): array
    {
        return [
            'admin_enqueue_scripts', new \stdClass(), 'enqueue_styles',
        ];
    }

    public function testAddAction(): void
    {
        $action = $this->getActionConfig();
        $pluginLoader = $this->getPluginLoader();
        $pluginLoader->addAction($action[0], $action[1], $action[2]);

        self::assertTrue(has_action('admin_enqueue_scripts', [MyClass::class, 'enqueue_styles']));
    }

    public function testPluginName(): void
    {
        $pluginKernel = $this->getPluginKernel();
        $pluginKernel->init();

        $this->assertEquals(self::PLUGIN_NAME, $pluginKernel->getPluginName());
    }

}