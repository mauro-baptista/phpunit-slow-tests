
# Get a better overview of the slowest tests in your suite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maurobaptista/phpunit-slow-tests.svg?style=flat-square)](https://packagist.org/packages/maurobaptista/phpunit-slow-tests)
[![Tests](https://github.com/maurobaptista/phpunit-slow-tests/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/maurobaptista/phpunit-slow-tests/actions/workflows/run-tests.yml)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

---

## Installation

You can install the package via composer:

```bash
composer require maurobaptista/phpunit-slow-tests
```

---

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

---

## Configuration

### ResultToCSV Extension

A CSV export of the time of all ran tests will be stored in this file.

```xml
<extensions>
    <extension class="MauroBaptista\SlowTests\Extensions\ResultToCSV">
        <arguments>
            <string>tests/report/result.csv</string>
        </arguments>
    </extension>
</extensions>
```

**Arguments:**

| Argument | Type | Default | Note |
| --- | --- | --- | --- |
| file | string | `result.csv` | Path to the file (can be a relative path) |

**Output:**

Console:

![Result to CSV](https://cdn.maurobaptista.com/packages/phpunit-slow-tests/result-to-csv.png)

File:

```csv
datetime,class,method,duration
"2022-11-08 02:06:23","Tests\Unit\ExampleTest",that_true_is_true,0.0055065
"2022-11-08 02:06:23","Tests\Feature\ExampleTest",that_true_is_true,0.186276667
```

### SlowestTests

```xml
<extensions>
    <extension class="MauroBaptista\SlowTests\Extensions\SlowestTests">
        <arguments>
            <integer>10</integer>
            <array>
                <element key="success">
                    <double>0.1</double>
                </element>
                <element key="warning">
                    <double>1</double>
                </element>
            </array>
        </arguments>
    </extension>
</extensions>
```

**Arguments:**

| Argument | Type | Default | Note |
| --- | --- | --- | --- |
| show | integer | 10 | Amount of tests that will be shown after the test ran |
| threshold | array | ['success' => 0.1, 'warning' => 1] | Time to show tests as green, yellow, or red (in seconds)|

**Output:**

Console:

![Slowest Tests](https://cdn.maurobaptista.com/packages/phpunit-slow-tests/slowest-tests.png)

---

## Testing

```bash
composer test
```

---

## Credits

- [Mauro Baptista](https://github.com/maurobaptista)

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
