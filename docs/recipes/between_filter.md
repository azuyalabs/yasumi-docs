# Holidays based on a given date range

Let's say you are running an online store, and you want to send shoppers a promotion e-mail about new seasonal products.
Yasumi can help you find holidays that occur in a certain date range.

For your shoppers in Italy, you would like to know which holidays occur in December. Simply use the Yasumi
'BetweenFilter' class like this:

```php
<?php

// Require the composer auto loader
require 'vendor/autoload.php';

$year = date('Y');

// Use the factory to create a new holiday provider instance
$holidays           = Yasumi\Yasumi::create('Italy', $year);
$holidaysInDecember = $holidays->between(
                        new DateTime('12/01/' . $year),
                        new DateTime('12/31/' . $year)
                      );
```

We then can see the following holidays in Italy in December:

```php
foreach ($holidaysInDecember as $holiday) {
    echo $holiday . ' - ' . $holiday->getName() . PHP_EOL;
}

// 2023-12-08 - Immaculate Conception
// 2023-12-25 - Christmas
// 2023-12-26 - St. Stephen’s Day
```

Using this, you can select new products that you would like to promote to your shoppers. Simple as that!

Use the `count` method to show how many holidays are present:

```php
echo $holidaysInDecember->count();

// 3
```

> Yasumi works only with holidays for the year you have specified when creating the holiday provider instance.
> This means that if you use either a start or end date beyond this year, holidays before or after the given year will
> not be retrieved.
