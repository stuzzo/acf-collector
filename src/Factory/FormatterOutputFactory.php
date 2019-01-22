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

use ACFCollector\Exception\OutputFormatterNotImplementedException;
use function call_user_func;

/**
 * Class FormatterOutputFactory
 * @package ACFCollector\Factory
 */
class FormatterOutputFactory
{
    /**
     * @since 1.0.0
     */
    const FORMATTERS_CLASS_PREFIX = 'ACFCollector\Formatter\Output';

    /**
     * Get the output field formatter by type
     *
     * @param string $type
     *
     * @return \ACFCollector\Formatter\Output\OutputFormatterInterface
     */
    public static function getFormatterForOutput($type)
    {
        $formatterClass = sprintf('%s\%sFormatter', self::FORMATTERS_CLASS_PREFIX, ucfirst($type));
        if (!class_exists($formatterClass, true)) {
            throw new OutputFormatterNotImplementedException($type);
        }

        return call_user_func(array($formatterClass, 'getInstance'));
    }
}