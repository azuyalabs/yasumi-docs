# Filter only certain holidays

Each Yasumi Holiday Provider contains many holidays that can be classified by different types. As you may
want to select a specific set of holidays, Yasumi provides a number of filters that can help you with
that. Yasumi comes currently with the following filters:

- **Official** - Holidays that are marked as public or statutory.
- **Observed** - Holidays that are not necessarily official however are being observed.
- **Bank** - A public holiday in the United Kingdom, some Commonwealth countries and some other European countries.
- **Seasonal** - Holidays that are celebrated due to its seasonal character (e.g. Halloween).
- **Other** - Holidays that fall outside any of the above type.
- **Between** - Filters all holidays between a given start and given end date. Check out
  this [recipe](/recipes/between_filter.md) on how to use the Between filter.
- **On** - Filters all holidays that happen on a given date.

So, how do we for example go about getting only the official holidays from Yasumi? In that case we can
use the 'OfficialHolidaysFilter'.

First, we start with the basics, using the Netherlands as an example:

``` php
<?php

// Require the composer auto loader
require 'vendor/autoload.php';

// Use the factory to create a new holiday provider instance
$holidays = Yasumi\Yasumi::create('Netherlands', (int) date('Y'));
```

Then we include the following line to create the filter object for the official holidays:

``` php
$official = new Yasumi\Filters\OfficialHolidaysFilter($holidays->getIterator());
```

That's all it takes! Now, you can use the usual Yasumi API methods to process the holidays (which are now
filtered). Which could look like this:

``` php
foreach ($official as $day) {
    echo $day->getName() . PHP_EOL;
}

// 'New Year’s Day'
// 'Easter Sunday'
// 'Easter Monday'
// 'Kings Day'
// 'Ascension Day'
// 'Whitsunday'
// 'Whitmonday'
// 'Christmas'
// 'Second Christmas Day'
```
