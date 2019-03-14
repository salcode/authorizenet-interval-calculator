<?php
/**
 * AuthorizeNetIntervalCalculator GetOccurenceDate Tests
 *
 * @package   salcode\AuthorizeNetIntervalCalculator
 * @author    Sal Ferrarello <sal@ironcodestudio.com>
 * @copyright 2019 Sal Ferrarello, Iron Code Studio
 * @license   apache-2.0
 */

namespace salcode\AuthorizeNetIntervalCalculator\Test;

use DateTimeImmutable;
use salcode\AuthorizeNetIntervalCalculator\AuthorizeNetIntervalCalculator;

/**
 * Class: GetOccurrenceDateTest
 */
class GetOccurrenceDateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test getDate
     *
     * @param int               $length     The number of units in an interval.
     * @param string            $unit       The unit to be used with the length
     *        when determining the interval.
     * @param DateTimeInterface $startDate  The date of the first payment.
     * @param int               $occurrence The occurrence we want to find the
     *        date for.
     * @param DateTimeInterface $expected   The expected result.
     *
     * @dataProvider dataProviderGetOccurrenceDateTime
     */
    public function testGetOccurrenceDateTimeTest(
        $length,
        $unit,
        $startDate,
        $occurrence,
        $expected
    ) {
        $calc = new AuthorizeNetIntervalCalculator($length, $unit, $startDate);
        $this->assertEquals(
            $expected,
            $calc->getDate($occurrence)
        );
    }

    /**
     * Data provider for testGetOccurrenceDateTimeTest
     */
    public function dataProviderGetOccurrenceDateTime()
    {
        return [
            [
                7, 'days', new DateTimeImmutable('2019-01-02 MST'),
                2, new DateTimeImmutable('2019-01-09 MST'),
            ],
            [
                14, 'days', new DateTimeImmutable('2019-12-31 MST'),
                2, new DateTimeImmutable('2020-01-14 MST'),
            ],
            [
                30, 'days', new DateTimeImmutable('2019-02-01 MST'),
                2, new DateTimeImmutable('2019-03-03 MST'),
            ],
            [
                365, 'days', new DateTimeImmutable('2019-01-02 MST'),
                2, new DateTimeImmutable('2020-01-02 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-02 MST'),
                2, new DateTimeImmutable('2019-02-02 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-31 MST'),
                2, new DateTimeImmutable('2019-02-28 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-31 MST'),
                14, new DateTimeImmutable('2020-02-29 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-31 MST'),
                38, new DateTimeImmutable('2022-02-28 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-31 MST'),
                62, new DateTimeImmutable('2024-02-29 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2020-01-31 MST'),
                2, new DateTimeImmutable('2020-02-29 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-03-31 MST'),
                2, new DateTimeImmutable('2019-04-30 MST'),
            ],
            [
                3, 'months', new DateTimeImmutable('2019-03-31 MST'),
                2, new DateTimeImmutable('2019-06-30 MST'),
            ],
            [
                3, 'months', new DateTimeImmutable('2019-03-31 MST'),
                3, new DateTimeImmutable('2019-09-30 MST'),
            ],
            [
                7, 'months', new DateTimeImmutable('2019-03-31 MST'),
                2, new DateTimeImmutable('2019-10-31 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-04-30 MST'),
                2, new DateTimeImmutable('2019-05-30 MST'),
            ],
        ];
    }
}
