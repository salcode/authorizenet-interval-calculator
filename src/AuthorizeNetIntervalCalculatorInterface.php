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
}
