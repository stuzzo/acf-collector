<?php

/*
 * This file is part of the ACF Collector plugin.
 *
 * (c) Alfredo Aiello <stuzzo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ACFCollector\Exception;

/**
 * Class FieldNotImplementedException
 * @package ACFCollector\Exception
 * @since 1.0.0
 */
final class FieldNotImplementedException extends \RuntimeException
{
    /**
     * FieldNotImplementedException constructor.
     *
     * @param string          $fieldType
     * @param int             $code
     * @param \Throwable|null $previous
     * @since 1.0.0
     */
    public function __construct($fieldType, $code = 0, \Throwable $previous = null)
    {
        $fullMessage = sprintf('Formatter for field type %s non implemented', $fieldType);
        parent::__construct($fullMessage, $code, $previous);
    }
}
