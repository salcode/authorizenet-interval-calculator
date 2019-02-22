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

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Class: AuthorizeNetIntervalCalculator
 *
 * @see AuthorizeNetIntervalCalculatorInterface
 */
class AuthorizeNetIntervalCalculator implements AuthorizeNetIntervalCalculatorInterface
{
    // Bounding values as defined by Authorize.Net.
    const MAX_NUM_OCCURRENCES = 9999;
    const MINIMUM_DAYS        = 7;
    const MAXIMUM_DAYS        = 365;
    const MINIMUM_MONTHS      = 1;
    const MAXIMUM_MONTHS      = 12;

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
     * @var DateTimeImmutable
     */
    protected $startDate;

    /**
     * Constructor
     *
     * @param int               $length The measurement of time, in association
     *        with unit, that is used to define the frequency of the billing
     *        occurrences. For a unit of days, use an integer between 7 and
     *        365, inclusive. For a unit of months, use an integer between 1
     *        and 12, inclusive.
     * @param string            $unit The unit of time, in association with the
     *        length, between each billing occurrence. Either 'days' or
     *        'months'.
     * @param DateTimeInterface $startDate The date of the first payment.
     *
     * @throws InvalidArgumentException When length and unit are not a
     *         valid combination.
     */
    public function __construct(int $length, string $unit, DateTimeInterface $startDate)
    {
        if (! $this->isLengthAndUnitValid($length, $unit)) {
            throw new InvalidArgumentException('The combination of length and unit are invalid');
        }
        $this->length    = $length;
        $this->unit      = $unit;
        $this->setStartDate($startDate);
    }

    /**
     * Is Length and Unit Valid
     *
     * @param int    $length The number of units in an interval.
     * @param string $unit   The unit to be used with the length when
     *        determining the interval.
     *
     * @return bool The combination of length and unit are valid.
     */
    protected function isLengthAndUnitValid(int $length, string $unit): bool
    {
        if ($unit === 'days' && $length >= self::MINIMUM_DAYS && $length <= self::MAXIMUM_DAYS) {
            return true;
        } elseif ($unit === 'months' && $length >= self::MINIMUM_MONTHS && $length <= self::MAXIMUM_MONTHS) {
            return true;
        }
        return false;
    }

    /**
     * Set startDate
     *
     * Since the startDate argument must implement the DateTimeInterface,
     * it may be either mutable or immutable. We store the startDate property
     * as an immutable value.
     *
     * @param DateTimeInterface $startDate The date of the first payment.
     */
    protected function setStartDate(DateTimeInterface $startDate)
    {
        // Set the startDate property as a DateTimeImmutable value.
        $this->startDate = $startDate instanceof DateTimeImmutable ?
            $startDate :
            DateTimeImmutable::createFromMutable($startDate);
    }
}
