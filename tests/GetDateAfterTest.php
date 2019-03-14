<?php
/**
 * AuthorizeNetIntervalCalculator GetDateAfter Tests
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
 * Class: GetDateAfterTest
 */
class GetDateAfterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test getDateAfter() method.
     *
     * @param int               $length     The number of units in an interval.
     * @param string            $unit       The unit to be used with the length
     *        when determining the interval.
     * @param DateTimeInterface $startDate  The date of the first payment.
     * @param DateTimeInterface $afterDate  The date we want to find an
     *        occurrence after.
     * @param DateTimeInterface $expected   The expected result.
     *
     * @dataProvider dataProviderGetDateAfter
     */
    public function testGetDateAfter(
        $length,
        $unit,
        $startDate,
        $afterDate,
        $expected
    ) {
        $calc = new AuthorizeNetIntervalCalculator($length, $unit, $startDate);
        $this->assertEquals(
            $expected,
            $calc->getDateAfter($afterDate)
        );
    }

    /**
     * Data provider for testGetDateAfter
     */
    public function dataProviderGetDateAfter()
    {
        return [
            [
                7, 'days', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('1980-01-02 MST'),
                new DateTimeImmutable('2019-01-02 MST'),
            ],
            [
                7, 'days', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('2019-01-10 MST'),
                new DateTimeImmutable('2019-01-16 MST'),
            ],
            [
                7, 'days', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('2019-01-20 MST'),
                new DateTimeImmutable('2019-01-23 MST'),
            ],
            [
                14, 'days', new DateTimeImmutable('2019-12-31 MST'),
                new DateTimeImmutable('2020-01-02 MST'),
                new DateTimeImmutable('2020-01-14 MST'),
            ],
            [
                30, 'days', new DateTimeImmutable('2019-02-01 MST'),
                new DateTimeImmutable('2019-02-08 MST'),
                new DateTimeImmutable('2019-03-03 MST'),
            ],
            [
                // 2020 is a Leap year.
                365, 'days', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('2021-01-02 MST'),
                new DateTimeImmutable('2022-01-01 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('1980-02-02 MST'),
                new DateTimeImmutable('2019-01-02 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-02 MST'),
                new DateTimeImmutable('2019-02-05 MST'),
                new DateTimeImmutable('2019-03-02 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2020-01-31 MST'),
                new DateTimeImmutable('2020-02-01 MST'),
                new DateTimeImmutable('2020-02-29 MST'),
            ],
            [
                1, 'months', new DateTimeImmutable('2019-01-31 MST'),
                new DateTimeImmutable('2019-06-01 MST'),
                new DateTimeImmutable('2019-06-30 MST'),
            ],
            [
                3, 'months', new DateTimeImmutable('2019-03-31 MST'),
                new DateTimeImmutable('2020-04-01 MST'),
                new DateTimeImmutable('2020-06-30 MST'),
            ],
            [
                7, 'months', new DateTimeImmutable('2019-03-31 MST'),
                new DateTimeImmutable('2020-09-01 MST'),
                new DateTimeImmutable('2020-12-31 MST'),
            ],
            [
                7, 'months', new DateTimeImmutable('2019-03-31 MST'),
                new DateTimeImmutable('2021-01-01 MST'),
                new DateTimeImmutable('2021-07-31 MST'),
            ],
        ];
    }
}
