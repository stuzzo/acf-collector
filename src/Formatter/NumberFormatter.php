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

/**
 * Class that formats number field
 *
 * @since      1.0.0
 */
class NumberFormatter extends BaseFormatter implements FormatterInterface
{
    protected $returnKeys = array(
        'default_value',
        'min',
        'max',
        'placeholder',
    );

    private function __construct() {}

    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
            $inst->init();
        }

        return $inst;
    }

    public function formatReturnValue($field)
    {
        $formattedFields = $this->filterArrayFieldByReturnKeys($field, $this->returnKeys);
        if (empty($field['value'])) {
            $formattedFields['value'] = 0;
        } else {
            $formattedFields['value'] = (int)$field['value'];
        }

        return $this->prepareFieldsForOutput($field, $formattedFields);
    }
}