Date Range
================

[![Build Status](https://travis-ci.org/warmans/date-range.svg?branch=master)](https://travis-ci.org/warmans/date-range)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/warmans/date-range/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/warmans/date-range/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/warmans/date-range/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/warmans/date-range/?branch=master)

## Relative

Thin wrapper around DateTime classes to simplify generating date ranges relative to the current date.

### Basic Usage

Create a range instance specifying its options:

    $range = new \DateRange\Relative(array('length'=>'60 DAY', 'interval'=>'P1D');

Export the specified range as an array:

    var_dump($range->getRange());

It will look something like this:

    array(
        '01-01-2014' => array('raw' => \DateTime, 'formatted' => '01-01-2014')
        '02-01-2014' => array('raw' => \DateTime, 'formatted' => '02-01-2014')
        //etc...
    )


### Options

| Option               | Example | Description
| -------------------- | ------- | --------------------------------------------------------------------
| length               | 30 DAYS | DateTime format relative date string
| modify               | -1 DAY  | Offset the date range by this DateTime format relative date string
| interval             | P1D     | DateInterval format interval
| date_format          | Y-m-d   | date() style date format for result