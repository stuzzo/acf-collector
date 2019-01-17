<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Automatically loads the specified file.
 */

define('ACF_COLLECTOR_BASE_NAMESPACE', 'ACFCollector');
define('ACF_COLLECTOR_SOURCE', 'src' . DIRECTORY_SEPARATOR);
/**
 * Automatically loads the specified file.
 *
 * Examines the fully qualified class name, separates it into components, then creates
 * a string that represents where the file is loaded on disk.
 *
 */
spl_autoload_register('acfCollectorAutoload');
function acfCollectorAutoload($requestClassNamespace)
{
    /**
     * If the class being requested does not start with our prefix,
     * we know it's not one in our project
     */
    if (0 !== strpos($requestClassNamespace, ACF_COLLECTOR_BASE_NAMESPACE)) {
        return;
    }

    $startFolder = sprintf('%s%s', ACF_COLLECTOR_PATH, ACF_COLLECTOR_SOURCE);
    $firstBackslashIndex = strpos($requestClassNamespace, '\\');
    $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($requestClassNamespace, $firstBackslashIndex + 1));
    $classFullPath = sprintf('%s%s.php', $startFolder, $relativePath);

    /**
     * If the class file not exists, we can't require it
     */
    if (!file_exists($classFullPath)) {
        return false;
    }

    require_once $classFullPath;
}