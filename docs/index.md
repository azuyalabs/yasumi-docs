![Yasumi Log](./assets/img/yasumi_logo.svg)

![Yasumi World Map](./assets/img/map.svg){ loading=lazy }

# Yasumi

The easy PHP Library for calculating holidays. Keep your **global** application in sync with holiday dates - Forever

**Yasumi** (Japanese for 'Holiday'「休み」) is the easy PHP library that helps you retrieve the dates and names of
holidays and other special celebrations from various countries/states. It is calculation and rule driven avoiding the
need of a comprehensive database.

## Why use Yasumi?

<div class="grid cards" markdown>

- :fontawesome-solid-earth-americas:{ .lg .middle .icon } **Easily extend new countries**

    ***

    New countries and holidays can be added comfortably as Yasumi is provider based and holidays are rule driven.

- :fontawesome-solid-landmark:{ .lg .middle .icon } **Use with any PHP framework**

    ***

    Yasumi is framework agnostic allowing you to use it anywhere, without trouble even when you decide to change your framework.

- :fontawesome-solid-language:{ .lg .middle .icon } **Speaks multiple languages**

    ***

    Yasumi comes out of the box with translations in many languages for all the holiday names, and is totally timezone aware.

- :fontawesome-solid-gear:{ .lg .middle .icon } **Open source**

    ***

    Yasumi is licensed under the [MIT License](https://github.com/azuyalabs/yasumi/blob/develop/LICENSE).

</div>

## Getting started

Be sure to include the Composer autoload file in your project:

```php
<?php

require 'vendor/autoload.php';

// Use the factory to create a new holiday provider instance
$holidays = Yasumi\Yasumi::create('USA', (int) date('Y'));
```

That's all it takes, you're ready to go!
