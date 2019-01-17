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

class FormatterFactory
{
    const FORMATTERS_CLASS_PREFIX = 'ACFCollector\Formatter';

    public static function getFormatter($type)
    {
        $formatterClass = sprintf('%s\%sFormatter', self::FORMATTERS_CLASS_PREFIX, ucfirst($type));
        if (!class_exists($formatterClass, true)) {
            throw new FieldNotImplementedException($type);
        }

        return call_user_func(array($formatterClass, 'getInstance'));
    }
}