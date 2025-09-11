# PDFAI
PDFAI is a simple PHP library that makes extracting data from PDFs for large language models easy. It uses a single dependency, the [Symfony Process Component](https://symfony.com/doc/current/components/process.html), to interface with the [Poppler command line tools from the xpdf library](https://poppler.freedesktop.org/).

## Install PDFAI
Install the library using Composer:

```shell
composer require 1tomany/pdf-ai
```

## Install Poppler
Before beginning, ensure the `pdfinfo`, `pdftoppm`, and `pdftotext` binaries are installed and located in the `$PATH` environment variables.

### macOS
```shell
brew install poppler
```

### Debian and Ubuntu
```shell
apt-get install poppler-utils
```

## Library Usage
This library has three main features:
- Read PDF metadata such as the number of pages
- Rasterize one or more pages to JPEG or PNG images
- Extract text from one or more pages

Extracted data is stored in memory and can be written to the filesystem or converted to a `data:` URI. Because extracted data is stored in memory, this library returns a `\Generator` object for each page that is extracted or rasterized.

Using the library is easy, and you have two ways to interact with it:

1. **Direct** Instantiate the `PopplerExtractorClient` class and call the methods directly. This method is easier to use, but makes testing harder because you can't easily swap the `PopplerExtractorClient` with the `MockExtractorClient` in your unit tests.
2. **Indirect** Create a container of `ExtractorClientInterface` objects, and use the `ExtractorClientFactory` class to instantiate them. If you wish to use the **indirect** method, I recommend you use the [Symfony bundle `1tomany/pdf-ai-bundle`](https://github.com/1tomany/pdf-ai-bundle) to take advantage of Symfony's container and autowiring features. While this method requires more upfront work, it makes testing much easier because you can easily swap the `PopplerExtractorClient` with the `MockExtractorClient` in your unit tests.

### Direct Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use OneToMany\PDFAI\Client\Poppler\PopplerExtractorClient;
use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Request\ExtractDataRequest;
use OneToMany\PDFAI\Request\ExtractTextRequest;
use OneToMany\PDFAI\Request\ReadMetadataRequest;

$filePath = '/path/to/file.pdf';

$client = new PopplerExtractorClient();

$metadata = $client->readMetadata(new ReadMetadataRequest($filePath));
printf("The PDF '%s' has %d page(s).\n", $filePath, $metadata->getPages());

// Rasterize pages 1 through 4 as 150 DPI JPEGs
$request = new ExtractDataRequest($filePath, 1, 4, OutputType::Jpg, 150);

foreach ($client->extractData($request) as $image) {
    // $image->getData() or $image->toDataUri()
    printf("MD5: %s\n", md5($image->getData()));
}

// Extract text from pages 3 and 4
$request = new ExtractTextRequest($filePath, 3, 4);

foreach ($client->extractData($request) as $text) {
    // $text->getData()
    printf("Length: %d\n", strlen($text->getData()));
}
```

### Run Test Suite
Run the test suite with PHPUnit:

```shell
./vendor/bin/phpunit
```

### Run Static Analysis
Run static analysis with PHPStan:

```shell
./vendor/bin/phpstan
```

## Credits
- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License
The MIT License
