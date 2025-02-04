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
use function get_option;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use function Brain\Monkey\Functions\stubs;
use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;
use function ob_end_clean;
use function ob_get_flush;
use function ob_start;
use function sprintf;

class ACFCollectorTestCase extends \PHPUnit\Framework\TestCase
{
    protected const PLUGIN_NAME = 'acf-collector';
    protected const PLUGIN_VERSION = '1.0.0';
    protected const ACF_COLLECTOR_FIELD_NAME = 'acf_collector_field';
    protected $jsonDir = '';

    // Adds Mockery expectations to the PHPUnit assertions count.
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        $this->jsonDir = sprintf('%s/Formatter/json', __DIR__);
        setUp();
        stubs(['load_plugin_textdomain'], true);
        stubs(['is_tax', 'is_category', 'is_tag', 'is_single', 'is_page', 'is_category', 'get_option'], false);
        stubs(['get_field_objects', 'get_term_meta', 'get_comment_meta', 'get_user_meta'], []);
    }

    public function tearDown()
    {
        tearDown();
        parent::tearDown();
    }

    protected function getRandomInt(): int
    {
        return \random_int(1, 100000000);
    }

    protected function getRandomString($length = 10): string
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', \random_int(1, 10))), 1, $length);
    }

    protected function getPluginLoader(): PluginLoader
    {
        return new PluginLoader();
    }

    protected function getACFCollectorFieldName(): string
    {
        return 'acf_collector_field';
    }
}
