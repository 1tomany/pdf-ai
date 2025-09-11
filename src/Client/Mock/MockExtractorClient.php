<?php

namespace OneToMany\PDFAI\Client\Mock;

use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PDFAI\Contract\Response\MetadataResponseInterface;
use OneToMany\PDFAI\Exception\RuntimeException;
use OneToMany\PDFAI\Response\MetadataResponse;

use function random_int;

readonly class MockExtractorClient implements ExtractorClientInterface
{
    public function __construct()
    {
    }

    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface
    {
        return new MetadataResponse(random_int(1, 100));
    }

    public function extractData(ExtractDataRequestInterface $request): ExtractedDataResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
