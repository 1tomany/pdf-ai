<?php

require_once __DIR__.'/../vendor/autoload.php';

use OneToMany\PDFAI\Client\Poppler\PopplerExtractorClient;
use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Request\ExtractDataRequest;
use OneToMany\PDFAI\Request\ExtractTextRequest;
use OneToMany\PDFAI\Request\ReadMetadataRequest;

$filePath = realpath(__DIR__.'/../tests/Client/files/pages-4.pdf');

$client = new PopplerExtractorClient();

$metadata = $client->readMetadata(new ReadMetadataRequest($filePath));
printf("The PDF '%s' has %d page(s).\n", $filePath, $metadata->getPages());

// Rasterize all pages as 150 DPI JPEGs
$request = new ExtractDataRequest($filePath, 1, null, OutputType::Jpg, 150);

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
