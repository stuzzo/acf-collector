<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Formatter;

use function in_array;

/**
 * Base class that contains only helper methods for formatters
 *
 * @since      1.0.0
 */
abstract class BaseFormatter
{

    protected $returnKeys;

    protected function getBaseReturnFields()
    {
        return array(
            'label',
            'name',
            'type',
        );
    }

    protected function init()
    {
        $this->returnKeys = array_merge($this->returnKeys, $this->getBaseReturnFields());
    }

    protected function filterArrayFieldByReturnKeys($field, $returnKeys)
    {
        $formattedFields = array();
        foreach ($field as $key => $value) {
            if (in_array($key, $returnKeys, true)) {
                $formattedFields[$key] = $value;
            }
        }

        return $formattedFields;
    }

    protected function prepareFieldsForOutput($field, $formattedFields)
    {
        return array($field['name'] => $formattedFields);
    }
}
