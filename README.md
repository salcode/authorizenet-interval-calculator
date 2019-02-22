# Authorize.Net Interval Calculator

PHP Library for Calculating Dates Corresponding to Authorize.Net's Recurring Billing Intervals.

## Example Usage

### Get Date: Seven Day Interval

```
$length    = 7;
$unit      = 'days';
$startDate = new DateTimeImmutable('2019-01-02');
$authNetIntervalCalc = new \salcode\AuthorizeNetIntervalCalculator\AuthorizeNetIntervalCalculator(
  $length,
  $unit,
  $startDate
);
for ($i=1; $i<5; $i++) {
  echo $authNetIntervalCalc->getDate($i)->format('Y-m-d');
}

## Output
# 2019-01-02
# 2019-01-09
# 2019-01-16
# 2019-01-23
```

### Get Date: One Month Interval

```
$length    = 1;
$unit      = 'months';
$startDate = new DateTimeImmutable('2019-01-31');
$authNetIntervalCalc = new \salcode\AuthorizeNetIntervalCalculator\AuthorizeNetIntervalCalculator(
  $length,
  $unit,
  $startDate
);
for ($i=1; $i<5; $i++) {
  echo $authNetIntervalCalc->getDate($i)->format('Y-m-d');
}

## Output
# 2019-01-31
# 2019-02-28
# 2019-03-31
# 2019-04-30
```

## Related Resources

- [Authorize.Net Recurring Billing API Documentation](https://developer.authorize.net/api/reference/index.html#recurring-billing), including intervals
