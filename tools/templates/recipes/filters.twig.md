# Filter only certain holidays

Each {{ siteName }} Holiday Provider contains many holidays that can be classified by different types. As you may
want to select a specific set of holidays, {{ siteName }} provides a number of filters that can help you with
that. {{ siteName }} comes currently with the following filters:

{% include('partials/filters_list.md') %}

So, how do we for example go about getting only the official holidays from {{ siteName }}? In that case we can
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

That's all it takes! Now, you can use the usual {{ siteName }} API methods to process the holidays (which are now
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
