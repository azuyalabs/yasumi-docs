# Create a Custom Provider

What if you want to manage holidays that are similar to those of a country but slightly different?

A good example of such a situation is the observed holidays by the New York Stock
Exchange ([NYSE](https://www.nyse.com/index)): All NYSE markets observe U.S. holidays however these differ somewhat from
the standard Federal U.S. holidays:

- The NYSE markets observe Good Friday as a holiday, where the Federal holidays do not celebrate this.
- The NYSE markets do not observe Columbus Day and Veterans Day as an official holiday

Yasumi is very flexible in that it can also work with custom holiday providers instead of the predefined
holiday providers.

First step is to create a custom class that extends an existing holiday provider. In this case, we are going to extend
the USA Holiday Provider class to form a new custom provider that covers the NYSE observed holidays. This new class will
then contain modifications that reflect differences from the U.S. holidays.

The custom holiday provider class will look like this:

```php
<?php

/**
 * Provider for all observed holidays by the NYSE (New York Stock Exchange)
 */
class NYSE extends \Yasumi\Provider\USA
{
    /**
     * Initialize holidays for the NYSE.
     * @throws \Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        // Add Good Friday
        $this->addHoliday($this->goodFriday($this->year, $this->timezone, $this->locale));

        // Remove Columbus Day and Veterans Day
        $this->removeHoliday('columbusDay');
        $this->removeHoliday('veteransDay');
    }
}
```

Here you can see, that we use Yasumi's `addHoliday` and `removeHoliday` methods to add Good Friday and,
respectively, remove Columbus Day and Veterans Day from the internal list of defined holidays.

Now we can instantiate a Yasumi Holiday Provider object with our new custom provider class:

```php
// Use the factory method to create a new holiday provider instance
$NYSEHolidays = Yasumi\Yasumi::create(NYSE::class, 2025);
```

We then can retrieve the NYSE observed holidays in 2025 in the usual manner:

```php
<?php

// Display all holidays
foreach ($NYSEHolidays as $day) {
    echo $day->getName() . PHP_EOL;
}

// 'New Year’s Day'
// 'Dr. Martin Luther King Jr’s Birthday'
// 'Washington’s Birthday'
// 'Good Friday'
// 'Memorial Day'
// 'Juneteenth'
// 'Independence Day'
// 'Labor Day'
// 'Thanksgiving Day'
// 'Christmas'
```

```php
<?php

// Use the count() method to show how many holidays are returned
echo $NYSEHolidays->count() . PHP_EOL;

// 10
```

> The `count` method does not double count holidays that are observed. Hence, in the example above 10 holidays are counted.

As you can see, Yasumi's open design allows even for scenarios that are atypical. Alternatively, you can
also create custom filters, however these are best suited for situations when you only need to exclude holidays from a
Holiday Provider.

Sources:

* [NYSE Holidays and Trading Hours](https://www.nyse.com/markets/hours-calendars)
