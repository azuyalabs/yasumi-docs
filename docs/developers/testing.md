# Testing

Yasumi includes a [PHPUnit](https://phpunit.de/) test suite that contains more than 4.8K unit tests with multiple
iterations of assertions. Since Yasumi is using randomized years for asserting the holidays,
multiple iterations of assertions get executed to ensure the holidays will be calculated for many years.

The tests are grouped in some test suites to make testing a bit easier:

- **"Base"**: For testing the base functionality of Yasumi

- **"Argentina"**: For separately testing the [Argentina](../providers/ar.md) Holiday Provider

- **"Australia"**: For separately testing the [Australia](../providers/au.md) Holiday Provider

- **"Austria"**: For separately testing the [Austria](../providers/at.md) Holiday Provider

- **"Belgium"**: For separately testing the [Belgium](../providers/be.md) Holiday Provider

- **"Bosnia"**: For separately testing the [Bosnia &amp; Herzegovina](../providers/ba.md) Holiday Provider

- **"Brazil"**: For separately testing the [Brazil](../providers/br.md) Holiday Provider

- **"Canada"**: For separately testing the [Canada](../providers/ca.md) Holiday Provider

- **"Croatia"**: For separately testing the [Croatia](../providers/hr.md) Holiday Provider

- **"CzechRepublic"**: For separately testing the [Czech Republic](../providers/cz.md) Holiday Provider

- **"Denmark"**: For separately testing the [Denmark](../providers/dk.md) Holiday Provider

- **"Estonia"**: For separately testing the [Estonia](../providers/ee.md) Holiday Provider

- **"Finland"**: For separately testing the [Finland](../providers/fi.md) Holiday Provider

- **"France"**: For separately testing the [France](../providers/fr.md) Holiday Provider

- **"Georgia"**: For separately testing the [Georgia](../providers/ge.md) Holiday Provider

- **"Germany"**: For separately testing the [Germany](../providers/de.md) Holiday Provider

- **"Greece"**: For separately testing the [Greece](../providers/gr.md) Holiday Provider

- **"Hungary"**: For separately testing the [Hungary](../providers/hu.md) Holiday Provider

- **"Iran"**: For separately testing the [Iran](../providers/ir.md) Holiday Provider

- **"Ireland"**: For separately testing the [Ireland](../providers/ie.md) Holiday Provider

- **"Italy"**: For separately testing the [Italy](../providers/it.md) Holiday Provider

- **"Japan"**: For separately testing the [Japan](../providers/jp.md) Holiday Provider

- **"Latvia"**: For separately testing the [Latvia](../providers/lv.md) Holiday Provider

- **"Lithuania"**: For separately testing the [Lithuania](../providers/lt.md) Holiday Provider

- **"Luxembourg"**: For separately testing the [Luxembourg](../providers/lu.md) Holiday Provider

- **"Mexico"**: For separately testing the [Mexico](../providers/mx.md) Holiday Provider

- **"Netherlands"**: For separately testing the [Netherlands](../providers/nl.md) Holiday Provider

- **"NewZealand"**: For separately testing the [New Zealand](../providers/nz.md) Holiday Provider

- **"Norway"**: For separately testing the [Norway](../providers/no.md) Holiday Provider

- **"Poland"**: For separately testing the [Poland](../providers/pl.md) Holiday Provider

- **"Portugal"**: For separately testing the [Portugal](../providers/pt.md) Holiday Provider

- **"Romania"**: For separately testing the [Romania](../providers/ro.md) Holiday Provider

- **"Russia"**: For separately testing the [Russia](../providers/ru.md) Holiday Provider

- **"Slovakia"**: For separately testing the [Slovakia](../providers/sk.md) Holiday Provider

- **"SouthAfrica"**: For separately testing the [South Africa](../providers/za.md) Holiday Provider

- **"SouthKorea"**: For separately testing the [South Korea](../providers/kr.md) Holiday Provider

- **"Spain"**: For separately testing the [Spain](../providers/es.md) Holiday Provider

- **"Sweden"**: For separately testing the [Sweden](../providers/se.md) Holiday Provider

- **"Switzerland"**: For separately testing the [Switzerland](../providers/ch.md) Holiday Provider

- **"Turkey"**: For separately testing the [Türkiye](../providers/tr.md) Holiday Provider

- **"USA"**: For separately testing the [United States](../providers/us.md) Holiday Provider

- **"Ukraine"**: For separately testing the [Ukraine](../providers/ua.md) Holiday Provider

- **"UnitedKingdom"**: For separately testing the [United Kingdom](../providers/gb.md) Holiday Provider

You will need a working installation of [Composer](https://getcomposer.org/ "Composer") before continuing.

First, install the dependencies:

``` shell
composer install
```

Then run `phpunit`:

``` shell
composer test
```

alternatively run with:

``` shell
vendor/bin/phpunit
```

If the test suite passes on your local machine you should be good to go.

When you make a pull request, the tests will automatically be run again by **GitHub Actions** on multiple php versions. In
addition, your pull requests are checked automatically for the proper PSR-12 coding style, with a static analysis
performed.
