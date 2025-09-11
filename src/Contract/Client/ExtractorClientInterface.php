<?php

namespace OneToMany\PDFExtractor\Contract\Client;

use OneToMany\PDFExtractor\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFExtractor\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PDFExtractor\Contract\Response\MetadataResponseInterface;

interface ExtractorClientInterface
{
    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface;

    public function extractData(ExtractDataRequestInterface $request): ExtractedDataResponseInterface;
}
