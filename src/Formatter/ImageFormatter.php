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
 * Class that formats image field
 *
 * @since      1.0.0
 */
class ImageFormatter extends BaseFormatter implements FormatterInterface
{
    protected $returnKeys = array(
        'label',
        'name',
        'return_format',
        'type',
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
            $formattedFields['value'] = '';
        } else {
            $formattedFields['value'] = $field['value'];
        }

        return $this->prepareFieldsForOutput($field, $formattedFields);
    }
}