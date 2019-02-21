<?php
/**
 * AuthorizeNetIntervalCalculator Validation Tests
 *
 * @package   salcode\AuthorizeNetIntervalCalculator
 * @author    Sal Ferrarello <sal@ironcodestudio.com>
 * @copyright 2018 Sal Ferrarello, Iron Code Studio
 * @license   apache-2.0
 */

namespace salcode\AuthorizeNetIntervalCalculator\Test;

use DateTimeImmutable;
use salcode\AuthorizeNetIntervalCalculator\AuthorizeNetIntervalCalculator;

/**
 * Class: ValidationTest
 */
class ValidationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test Validation
     *
     * @param int               $length    The number of units in an interval.
     * @param string            $unit      The unit to be used with the length
     *        when determining the interval.
     * @param DateTimeInterface $startDate The date of the first payment.
     * @param string            $exception The exception to expect (or empty
     *        string for no exception).
     *
     * @dataProvider validationProvider
     */
    public function testValidation($length, $unit, $startDate, $exception)
    {
        if ($exception !== '') {
            $this->expectException($exception);
        }
        $calculator = new AuthorizeNetIntervalCalculator(
            $length,
            $unit,
            $startDate
        );
        $this->assertTrue(true);
    }

    /**
     * Data provider for testValidation.
     */
    public function validationProvider()
    {
        $dateTime = new DateTimeImmutable();
        return [
            [ 7,      'days',          $dateTime, '' ],
            [ 6,      'days',          $dateTime, 'InvalidArgumentException' ],
            [ 0,      'days',          $dateTime, 'InvalidArgumentException' ],
            [ -11,    'days',          $dateTime, 'InvalidArgumentException' ],
            [ 101,    'days',          $dateTime, '' ],
            [ 365,    'days',          $dateTime, '' ],
            [ 366,    'days',          $dateTime, 'InvalidArgumentException' ],
            [ 843254, 'days',          $dateTime, 'InvalidArgumentException' ],
            [ 4,      'months',        $dateTime, '' ],
            [ 1,      'months',        $dateTime, '' ],
            [ 0,      'months',        $dateTime, 'InvalidArgumentException' ],
            [ 7,      'months',        $dateTime, '' ],
            [ 11,     'months',        $dateTime, '' ],
            [ 12,     'months',        $dateTime, '' ],
            [ 13,     'months',        $dateTime, 'InvalidArgumentException' ],
            [ 83,     'months',        $dateTime, 'InvalidArgumentException' ],
            [ 7,      'snergleflirts', $dateTime, 'InvalidArgumentException' ],
            [ 12,     'day',           $dateTime, 'InvalidArgumentException' ],
            [ 12,     'month',         $dateTime, 'InvalidArgumentException' ],
        ];
    }
}
