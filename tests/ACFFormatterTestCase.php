<?php

namespace ACFFormatter\Tests;

use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class ACFFormatterTestCase extends \PHPUnit\Framework\TestCase
{
    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        setUp();
    }

    public function tearDown()
    {
        tearDown();
        parent::tearDown();
    }
}
