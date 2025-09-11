# PDFAI
PDFAI is a simple PHP library that makes extracting data from PDFs for large language models easy. It uses a single dependency, the [Symfony Process Component](https://symfony.com/doc/current/components/process.html) to interface with the [Poppler command line tools from the xpdf library](https://poppler.freedesktop.org/).

This library has three main features:
- Read PDF metadata such as the number of pages
- Rasterize one or more pages to JPEG or PNG images
- Extract text from one or more pages

Extracted data is stored in memory and can be written to the filesystem or converted to a `data:` URI.

## Installation
Install the library using Composer:

```shell
composer require 1tomany/pdf-ai
```

## Run Test Suite
Run the test suite with PHPUnit:

```shell
./vendor/bin/phpunit
```

## Run Static Analysis
Run static analysis with PHPStan:

```shell
./vendor/bin/phpstan
```

## Credits
- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License
The MIT License
