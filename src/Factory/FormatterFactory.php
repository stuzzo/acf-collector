<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Factory;

use ACFCollector\Exception\FieldNotImplementedException;
use function call_user_func;
use function str_replace;
use function ucfirst;
use function ucwords;

/**
 * Class FormatterFactory
 * @package ACFCollector\Factory
 */
class FormatterFactory
{
    /**
     * @since 1.0.0
     */
    const FORMATTERS_CLASS_PREFIX = 'ACFCollector\Formatter';

    /**
     * Get the field formatter by type
     *
     * @param string $type
     *
     * @return \ACFCollector\Formatter\FormatterInterface
     * @since 1.0.0
     */
    public static function getFormatter($type)
    {
        $formatterType = self::getPascalCaseFormatterType($type);
        $formatterClass = sprintf('%s\%sFormatter', self::FORMATTERS_CLASS_PREFIX, $formatterType);
        if (!class_exists($formatterClass, true)) {
            throw new FieldNotImplementedException($type);
        }

        return call_user_func(array($formatterClass, 'getInstance'));
    }

    /**
     * Return the Pascal Case representation of the field type
     * @param string $type
     *
     * @return string
     * @since 1.0.0
     */
    private static function getPascalCaseFormatterType($type)
    {
        $type = str_replace('_', ' ', $type);

        return str_replace(' ', '', ucwords($type));
    }
}