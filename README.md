
# Get a better overview of the slowest tests in your suite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maurobaptista/phpunit-slow-tests.svg?style=flat-square)](https://packagist.org/packages/maurobaptista/phpunit-slow-tests)
[![Tests](https://github.com/maurobaptista/phpunit-slow-tests/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/maurobaptista/phpunit-slow-tests/actions/workflows/run-tests.yml)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require maurobaptista/phpunit-slow-tests
```

## Usage

In your `phpunit.xml` file, add the extensions as below.
```xml
  <extensions>
    <extension class="MauroBaptista\SlowTests\Extensions\ResultToCSV">
      <arguments>
        <string>tests/report/result.csv</string>
      </arguments>
    </extension>
    <extension class="MauroBaptista\SlowTests\Extensions\SlowestTests" />
  </extensions>
```

## Testing

```bash
composer test
```

## Credits

- [Mauro Baptista](https://github.com/maurobaptista)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
