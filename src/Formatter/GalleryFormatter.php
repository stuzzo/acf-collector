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
 * Class that formats gallery field
 *
 * @since      1.0.0
 */
class GalleryFormatter extends BaseFormatter
{
    /**
     * GalleryFormatter constructor.
     */
    private function __construct()
    {
        $this->defaultOutputFormatterType = self::ARRAY_OUTPUT_FORMATTER_TYPE;
    }

    /**
     * @return \ACFCollector\Formatter\FormatterInterface
     *
     * @since 1.0.0
     */
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }

        return $inst;
    }

    /**
     * @param array $field
     * @param bool  $isOutputFiltered
     *
     * @return array
     * @since 1.0.0
     */
    public function format($field, $isOutputFiltered)
    {
        if (empty($field['value'])) {
            return array();
        }

        $images = array();
        foreach ($field['value'] as $image) {
            if ($isOutputFiltered) {
                $images[] = [
                    'url' => $image['url'],
                    'sizes' => $image['sizes'],
                ];
            } else {
                $images[] = $image;
            }

        }

        return array($field['name'] => $images);
    }

}