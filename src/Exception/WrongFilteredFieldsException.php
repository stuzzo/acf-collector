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
 * Class WrongFilteredFieldsException
 * @package ACFCollector\Exception
 * @since 1.0.0
 */
final class WrongFilteredFieldsException extends \RuntimeException
{
    /**
     * WrongFilteredFieldsException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     * @since 1.0.0
     */
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
