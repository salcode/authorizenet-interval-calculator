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

/**
 * Interface: AuthorizeNetIntervalCalculatorInterface
 */
interface AuthorizeNetIntervalCalculatorInterface
{
    /**
     * Get DateTime of Occurrence
     *
     * @param int $occurrence The occurrence we want to find the date for.
     *
     * @return DateTimeImmutable The DateTime of the next occurrence.
     * @throws InvalidArgumentException When the occurrence value is outside
     *         the accepted range.
     */
    public function getDate(int $occurrence): DateTimeImmutable;

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
    public function getDateAfter(DateTimeInterface $afterDate): DateTimeImmutable;
}
