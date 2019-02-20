<?php
/**
 * AuthorizeNetIntervalCalculator Tests
 *
 * @package   salcode\AuthorizeNetIntervalCalculator
 * @author    Sal Ferrarello <sal@ironcodestudio.com>
 * @copyright 2018 Iron Code Studio
 * @license   apache-2.0
 */

namespace salcode\AuthorizeNetIntervalCalculator\Test;

use salcode\AuthorizeNetIntervalCalculator\AuthorizeNetIntervalCalculator;

/**
 * Class: AuthorizeNetIntervalCalculatorTest
 */
class AuthorizeNetIntervalCalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * TestConstructor
     */
    public function testConstructor()
    {
        $calculator = new AuthorizeNetIntervalCalculator();
        $this->assertTrue(true);
    }
}
