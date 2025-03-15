# Getting Started

Using Yasumi in your projects is super easy! Yasumi is available
on [Packagist](https://packagist.org/packages/azuyalabs/yasumi "Yasumi on Packagist") and can be
installed using [Composer](https://getcomposer.org/ "Composer").

## System Requirements

You need **PHP >= 8.1** to use Yasumi, but the latest stable version of PHP is recommended. Yasumi is
verified and tested on PHP 8.1 or higher. Other versions of PHP are no longer supported.

Please see the [Security and Support Policy](security.md) for more details.

---

## Installation

Install `azuyalabs/yasumi` using Composer by issuing the following command:

``` shell
composer require azuyalabs/yasumi
```

Be sure to include the Composer autoload file in your project:

``` php
<?php

require 'vendor/autoload.php';

// Use the factory to create a new holiday provider instance
$holidays = Yasumi\Yasumi::create('USA', (int) date('Y'));
```

That's all it takes; you're ready to go!

Interested in learning more about Yasumi? Have a look at the Cookbook section; this section includes various recipes,
examples and how-to's to [get started](recipes/basic.md) with Yasumi.
