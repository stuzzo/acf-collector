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
 * Class that formats wysiwyg field
 *
 * @since      1.0.0
 */
class WysiwygFormatter  extends BaseFormatter implements FormatterInterface
{
    protected $returnKeys = array(
        'default_value',
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

    public function format($field)
    {
        $formattedFields = $this->filterArrayFieldByReturnKeys($field, $this->returnKeys);
        if (empty($field['value'])) {
            $formattedFields['value'] = '';
        } else {
            $formattedFields['value'] = (string)$field['value'];
        }

        return $this->prepareFieldsForOutput($field, $formattedFields);
    }
}