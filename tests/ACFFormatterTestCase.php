<?php

namespace ACFFormatter\Tests;

use function Brain\Monkey\Functions\stubs;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class ACFFormatterTestCase extends \PHPUnit\Framework\TestCase
{
    protected const PLUGIN_NAME = 'acf-formatter';
    protected const PLUGIN_VERSION = '1.0.0';

    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        setUp();
        stubs(
            [
                'load_plugin_textdomain' => true,
            ]
        );
    }

    public function tearDown()
    {
        tearDown();
        parent::tearDown();
    }
}
