<?php
/**
 * AuthorizeNetIntervalCalculator
 *
 * @package   salcode\AuthorizeNetIntervalCalculator
 * @author    Sal Ferrarello <sal@ironcodestudio.com>
 * @copyright 2018 Sal Ferrarello, Iron Code Studio
 * @license   apache-2.0
 */

declare(strict_types=1);

namespace salcode\AuthorizeNetIntervalCalculator;

use DateTimeInterface;

/**
 * Class: AuthorizeNetIntervalCalculator
 *
 * @see AuthorizeNetIntervalCalculatorInterface
 */
class AuthorizeNetIntervalCalculator implements AuthorizeNetIntervalCalculatorInterface
{

    /**
     * Length
     *
     * The number of units in an interval.
     *
     * @var int
     */
    protected $length;

    /**
     * Unit
     *
     * The unit to be used with the length when determining the interval.
     * Valid values: 'days', 'months'
     *
     * @var string
     */
    protected $unit;

    /**
     * Start Date of subscription
     *
     * @var DateTimeInterface
     */
    protected $startDate;

    /**
     * Constructor
     *
     * @param int               $length The measurement of time, in association
     *                  with unit, that is used to define the frequency of the
     *                  billing occurrences. For a unit of days, use an integer
     *                  between 7 and 365, inclusive. For a unit of months,
     *                  use an integer between 1 and 12, inclusive.
     * @param string            $unit The unit of time, in association with the
     *                  length, between each billing occurrence. Either 'days'
     *                  or 'months'.
     * @param DateTimeInterface $startDate The date of the first payment.
     *
     * @throws Exception When length and unit are not valid.
     */
    public function __construct(int $length, string $unit, DateTimeInterface $startDate)
    {
        if (! $this->isLengthAndUnitValid($length, $unit)) {
            throw Exception('This is not valid');
        }
        $this->length    = $length;
        $this->unit      = $unit;
        $this->startDate = $startDate;
    }

    /**
     * Is Length and Unit Valid
     *
     * @param int    $length The number of units in an interval.
     * @param string $unit   The unit to be used with the length when
     *                       determining the interval.
     *
     * @return bool The combination of length and unit are valid.
     */
    protected function isLengthAndUnitValid(int $length, string $unit)
    {
        return true;
    }
}
