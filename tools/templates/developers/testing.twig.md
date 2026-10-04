# Testing

{{ siteName }} includes a [PHPUnit](https://phpunit.de/) test suite that contains more than {{ tests_count
| human_friendly }} unit tests with multiple
iterations of assertions. Since {{ siteName }} is using randomized years for asserting the holidays,
multiple iterations of assertions get executed to ensure the holidays will be calculated for many years.

The tests are grouped in some test suites to make testing a bit easier:

- **"Base"**: For testing the base functionality of {{ siteName }}
{% for id, test in test_suites %}

- **"{{ test.suite|e }}"**: For separately testing the [{{ test.name }}](../providers/{{ id }}.md) Holiday Provider
{% endfor %}

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
