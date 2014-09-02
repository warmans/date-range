Date Range
================

### Relative

Utility for generating date range arrays relative to the current date.

```
$range = new \Util\DateRange(array('length'=>'60 DAY', 'interval'=>'P1D');
var_dump($range->getRange()); //the last 60 days
```

