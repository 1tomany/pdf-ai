# PDFAI
PDFAI is a simple PHP library that makes extracting data from PDFs for large language models easy. It uses a single dependency, the [Symfony Process Component](https://symfony.com/doc/current/components/process.html), to interface with the [Poppler command line tools from the xpdf library](https://poppler.freedesktop.org/).

This library has three main features:
- Read PDF metadata such as the number of pages
- Rasterize one or more pages to JPEG or PNG images
- Extract text from one or more pages

Extracted data is stored in memory and can be written to the filesystem or converted to a `data:` URI.

Using the library is easy, and you have two ways to interact with it:

1. **Direct** Instantiate the `PopplerExtractorClient` class and call the methods directly.
2. **Indirect** Create a container of `ExtractorClientInterface` objects, and use the `ExtractorClientFactory` class to instantiate them. If you wish to use the **indirect** method, I recommend you use the [Symfony bundle `1tomany/pdf-ai-bundle`](https://github.com/1tomany/pdf-ai-bundle) to take advantage of Symfony's container and autowiring features.

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
