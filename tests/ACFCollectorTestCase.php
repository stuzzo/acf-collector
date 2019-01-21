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

namespace ACFCollector\Tests;

use ACFCollector\Main\PluginLoader;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use function Brain\Monkey\Functions\stubs;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

class ACFCollectorTestCase extends \PHPUnit\Framework\TestCase
{
    protected const PLUGIN_NAME = 'acf-collector';
    protected const PLUGIN_VERSION = '1.0.0';
    protected const ACF_COLLECTOR_FIELD_NAME = 'acf_collector_field';

    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        setUp();
        stubs(['load_plugin_textdomain'], true);
        stubs(['is_tax', 'is_category', 'is_tag', 'is_single', 'is_page', 'is_category'], false);
        stubs(['get_field_objects', 'get_term_meta'], []);
    }

    public function tearDown()
    {
        tearDown();
        parent::tearDown();
    }

    protected function getRandomInt()
    {
        return \random_int(1, 100000000);
    }

    protected function getRandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', \random_int(1, 10))), 1, $length);
    }

    protected function getPluginLoader(): PluginLoader
    {
        return new PluginLoader();
    }
}
