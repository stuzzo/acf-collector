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
 * Class that formats flexible content field
 *
 * @since      1.0.0
 */
class FlexibleContentFormatter extends BaseFormatter
{
    /**
     * FlexibleContentFormatter constructor.
     *
     * @since 1.0.0
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
        $this->setOutputFormatterByField($field);

        $subFieldsDefinitions = isset($field['layouts']) ? $field['layouts'] : array();
        $subFieldsBlocks = ($field['value'] && $field['value'] !== false) ? $field['value'] : array();
        $formattedData = array();

        //Ciclo le definizioni dei campi
        foreach ($subFieldsDefinitions as $subFieldsDefinition) {
            $formattedData[$subFieldsDefinition['name']] = array();
            //Per ogni definizione, ciclo sui campi che contiene
            foreach ($subFieldsDefinition['sub_fields'] as $subFieldDefinition) {
                // ciclo i blocchi per cercare la chiave corrispondente poichè l'ordinamento non è sempre uguale tra
                // $subFieldsBlocks e $subFieldsDefinition['sub_fields'] e non ci si può basare sull'indice
                foreach ($subFieldsBlocks as $subFieldsBlock) {
                    if (array_key_exists($subFieldDefinition['name'], $subFieldsBlock)) {
                        //Prendo il valore del campo corrente
                        $currentSubFieldValue = $subFieldsBlock[$subFieldDefinition['name']];
                        //Associo alla definizione, il suo valore
                        $subFieldDefinition['value'] = $currentSubFieldValue;
                        //Restituisco il campo formattato
                        $formattedData[$subFieldsDefinition['name']] += parent::format($subFieldDefinition, $isOutputFiltered);
                        break;
                    }
                }
            }

        }
        $field['value'] = $formattedData;

        return $this->prepareFieldsForOutput($field, $isOutputFiltered);
    }
}