<?php

namespace ACFCollector\Tests;

use function Brain\Monkey\Functions\stubs;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class ACFCollectorTestCase extends \PHPUnit\Framework\TestCase
{
    protected const PLUGIN_NAME = 'acf-collector';
    protected const PLUGIN_VERSION = '1.0.0';

    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        setUp();
        stubs(
            ['load_plugin_textdomain'],
            true
        );
        stubs(
            ['get_field_objects'],
            []
        );
    }

    public function tearDown()
    {
        tearDown();
        parent::tearDown();
    }
}
