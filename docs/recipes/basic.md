# A basic starter

Yasumi is very easy to use. Let's find out how easy with this basic exercise.

We need to include Yasumi using the Composer autoloader first, then we can create a new holiday provider
instance (we will be using the United States of America):

``` php
<?php

require 'vendor/autoload.php';

// Use the factory to create a new holiday provider instance
$holidays = Yasumi\Yasumi::create('USA', (int) date('Y'));
```

Now we can access and use the various API methods of Yasumi. Let's see how many holidays the US has in
2023:

``` php
<?php

// Get the number of defined holidays
echo $holidays->count() . PHP_EOL;

// 11 (Substituted holidays are only accounted for once)
```

To get an overview of all the holidays of the US, we can simply loop through the results since each Yasumi
Holiday Provider implements the [ArrayIterator](https://www.php.net/manual/en/class.arrayiterator.php). Getting a
list of holidays for the US with the internal short names can be obtained as follows:

``` php-inline
// Get a list all of the holiday names (short names)
foreach ($holidays->getHolidayNames() as $name) {
    echo $name . PHP_EOL;
}

// 'newYearsDay'
// 'substituteHoliday:newYearsDay'
// 'martinLutherKingDay'
// 'washingtonsBirthday'
// 'memorialDay'
// 'juneteenth'
// 'independenceDay'
// 'labourDay'
// 'columbusDay'
// 'veteransDay'
// 'substituteHoliday:veteransDay'
// 'thanksgivingDay'
// 'christmasDay'
```

> These short names are not the names used for display purposes: they are simply used as internal identifiers by Yasumi.
> Later we will see how we can use the (display) names of holidays we are typically used to.

Now let's get all the holiday dates:

``` php
// Get a list all of the holiday dates
foreach ($holidays->getHolidayDates() as $date) {
    echo $date . PHP_EOL;
}

// 2023-01-01
// 2023-01-02
// 2023-01-16
// 2023-02-20
// 2023-05-29
// 2023-06-19
// 2023-07-04
// 2023-09-04
// 2023-10-09
// 2023-11-10
// 2023-11-11
// 2023-11-23
// 2023-12-25
```

Independence Day is an important holiday in the US. What details can Yasumi tell us about this holiday?
Using the 'getHoliday' function we can retrieve information like the localized name, date and type of holiday of
Independence Day:

``` php
// Get a holiday object for Independence Day
$independenceDay = $holidays->getHoliday('independenceDay');

// Get the localized name
echo $independenceDay->getName() . PHP_EOL;

// 'Independence Day'

// Get the date
echo $independenceDay . PHP_EOL;

// '2023-07-04'

// Get the type of holiday
echo $independenceDay->getType() . PHP_EOL;

// 'official'
```

Lastly, if you are a developer, you might be interested in getting the holiday information as a JSON object:

``` php
// Print the holiday as a JSON object
echo json_encode($independenceDay, JSON_PRETTY_PRINT);

// {
//     "shortName": "independenceDay",
//     "translations": {
//         "en": "Independence Day"
//     },
//     "date": "2023-07-04 00:00:00.000000",
//     "timezone_type": 3,
//     "timezone": "America\/New_York"
// }
```
