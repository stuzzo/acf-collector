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

namespace ACFFormatter\Tests\Handler;

use ACFCollector\Handler\ACFHandler;
use ACFCollector\Handler\TemplateHandler;
use ACFCollector\Tests\ACFCollectorTestCase;
use function Brain\Monkey\Functions\stubs;
use function get_comments;
use function has_filter;
use stdClass;
use WP_Comment;
use WP_Term;

class TemplateHandlerTest extends ACFCollectorTestCase
{
    public function testAddAction(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        $templateHandler->init();
        $pluginLoader->run();

        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentPost']));
        self::assertTrue(has_filter('template_redirect', [$templateHandler, 'addFieldsToCurrentTaxonomy']));
        self::assertTrue(has_filter('get_comment', [$templateHandler, 'addFieldsToCurrentComment']));
        self::assertTrue(has_filter('get_user_custom_fields', [$templateHandler, 'addFieldsToCurrentUser']));
        self::assertTrue(has_filter('wp_get_nav_menu_object', [$templateHandler, 'addFieldsToCurrentMenu']));
        self::assertTrue(has_filter('wp_get_nav_menus', [$templateHandler, 'addFieldsToCurrentMenus']));
    }

    public function testAddFieldsToCurrentPost(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        global $post;
        $post = new stdClass();
        $templateHandler->addFieldsToCurrentPost();

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $post);
    }

    public function testAddFieldsToCurrentTaxonomy(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        global $wp_query;
        $wp_query = new stdClass();
        $mock = \Mockery::mock(WP_Term::class);
        $wp_query->queried_object = $mock;
        stubs(['get_queried_object'], $wp_query->queried_object);
        $templateHandler->addFieldsToCurrentTaxonomy();

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $wp_query->queried_object);
    }

    public function testAddFieldsToCurrentComment(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        $mock = \Mockery::mock(WP_Comment::class);
        $templateHandler->addFieldsToCurrentComment($mock);

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $mock);
    }

    public function testAddFieldsToCurrentMenu(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        $mock = \Mockery::mock(WP_Term::class);
        $mock->taxonomy = 'nav_menu';
        $templateHandler->addFieldsToCurrentMenu($mock);

        $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $mock);
    }

    public function testAddFieldsToCurrentMenus(): void
    {
        $pluginLoader = $this->getPluginLoader();
        $templateHandler = new TemplateHandler($pluginLoader, ACFHandler::getInstance(), $this->getACFCollectorFieldName());
        $mock = \Mockery::mock(WP_Term::class);
        $mock->taxonomy = 'nav_menu';
        $menus = [$mock];
        $templateHandler->addFieldsToCurrentMenus($menus, []);

        foreach ($menus as $menu) {
            $this->assertObjectHasAttribute(self::ACF_COLLECTOR_FIELD_NAME, $menu);
        }

    }

}