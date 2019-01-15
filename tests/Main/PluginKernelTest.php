<?php

namespace ACFFormatter\Tests\Main;

use ACFFormatter\Main\PluginKernel;
use ACFFormatter\Tests\ACFFormatterTestCase;

class PluginKernelTest extends ACFFormatterTestCase
{
    public const VERSION = '1.0.0';

    public function testPluginVersion(): void
    {
        $pluginKernel = new PluginKernel();
        $pluginKernel->init();

        $this->assertEquals(self::VERSION, $pluginKernel->getVersion());
    }
}