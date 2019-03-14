<?php
/**
 * AuthorizeNetIntervalCalculator
 *
 * @package   salcode\AuthorizeNetIntervalCalculator
 * @author    Sal Ferrarello <sal@ironcodestudio.com>
 * @copyright 2019 Sal Ferrarello, Iron Code Studio
 * @license   apache-2.0
 */

declare(strict_types=1);

namespace salcode\AuthorizeNetIntervalCalculator;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use LogicException;
use RangeException;

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
     * Get DateTime of Occurrence
     *
     * @param int $occurrence The occurrence we want to find the date for.
     *
     * @return DateTimeImmutable The DateTime of the next occurrence.
     * @throws InvalidArgumentException When the occurrence value is outside
     *         the accepted range.
     * @throws LogicException When the unit property has an invalid value.
     */
    public function getDate(int $occurrence): DateTimeImmutable
    {
        if ($occurrence < 1 || $occurrence > self::MAX_NUM_OCCURRENCES) {
            throw new InvalidArgumentException(
                'The occurrence number '.$occurrence.' is outside the acceptable range'
            );
        }
        // Occurrence 1 is the startDate (i.e. 0 number of periods).
        $numOfPeriods = ($occurrence-1) * $this->length;

        if ($this->unit === 'days') {
            return $this->getDateUsingDays($numOfPeriods);
        } elseif ($this->unit === 'months') {
            return $this->getDateUsingMonths($numOfPeriods);
        }
        throw new LogicException('unit property has an invalid value'.$this->unit);
    }

    /**
     * Get DateTime of Occurence after given DateTime.
     *
     * @param DateTimeInterface $afterDate The DateTime we want to use as a
     *        lower bound (non-inclusive).
     *
     * @return DateTimeImmutable The DateTime of the first occurrence after
     *         the given DateTime.
     * @throws RangeException When no occurrence (within Authorize.Net's
     *         maximum number of occurences) falls after the given DateTime.
     *         Note: Based on the current minimum and maximum bounds of a
     *         PHP DateTimeImmutable object, this should never occur.
     */
    public function getDateAfter(DateTimeInterface $afterDate): DateTimeImmutable
    {
        // The first occurrence is one, not zero.
        $occurrenceNum  = 1;
        $occurrenceDate = $this->getDate($occurrenceNum);
        while ($afterDate > $occurrenceDate) {
            $occurrenceNum++;
            if ($occurrenceNum > self::MAX_NUM_OCCURRENCES) {
                throw new RangeException(
                    'Unable to find occurrence within maximum number of occurrences ('.self::MAX_NUM_OCCURRENCES.')'
                );
            }
            $occurrenceDate = $this->getDate($occurrenceNum);
        }
        return $occurrenceDate;
    }

    /**
     * Get DateTime of Occurrence using Days
     *
     * @param int $numOfPeriods The number of periods to look ahead.
     *
     * @return DateTimeImmutable The DateTime for the occurrence after the given
     *         number of periods.
     */
    protected function getDateUsingDays(int $numOfPeriods): DateTimeImmutable
    {
        return $this->startDate->modify(
            sprintf('+%d days', $numOfPeriods)
        );
    }

    /**
     * Get DateTime of Occurrence using Months
     *
     * Because the definition of a month in PHP can lead to unexpected values,
     * we must add some additional logic.
     * e.g. echo date('Y-m-d', strtotime('2018-01-31 +1 month'));
     * displays "2018-03-03" instead of "2018-02-28"
     *
     * See https://stackoverflow.com/a/5760371.
     *
     * @param int $numOfPeriods The number of periods to look ahead.
     *
     * @return DateTimeImmutable The DateTime for the occurrence after the given
     *         number of periods.
     */
    protected function getDateUsingMonths(int $numOfPeriods): DateTimeImmutable
    {
        $startDay = $this->startDate->format('j');
        $occurrenceDate = $this->startDate->modify(
            sprintf('+%d months', $numOfPeriods)
        );
        if ($occurrenceDate->format('j') === $startDay) {
            return $occurrenceDate;
        }

        // The occurrence day of the month is different from the startDate
        // day of the month.
        // e.g. "2018-01-31" has a day of the month of '31'
        // "2018-01-31 + 1 month" is "2018-03-03", which has a day of the month
        // of "03".
        // In this case, we want the last day
        // of the previous month.
        return $occurrenceDate->modify('last day of last month');
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
