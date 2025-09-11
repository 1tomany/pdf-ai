<?php

namespace OneToMany\PDFExtractor\Client\Mock;

use OneToMany\PDFExtractor\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFExtractor\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFExtractor\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PDFExtractor\Contract\Response\MetadataResponseInterface;
use OneToMany\PDFExtractor\Exception\RuntimeException;
use OneToMany\PDFExtractor\Response\FileResponse;

use function random_int;

readonly class MockRasterClient implements ExtractorClientInterface
{
    public function __construct()
    {
    }

    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface
    {
        return new FileResponse(random_int(1, 100));
    }

    public function extractData(ExtractDataRequestInterface $request): ExtractedDataResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
