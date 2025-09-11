<?php

namespace OneToMany\PDFAI\Contract\Client;

use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PDFAI\Contract\Response\MetadataResponseInterface;

interface ExtractorClientInterface
{
    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface;

    /**
     * @return \Generator<int, ExtractedDataResponseInterface>
     */
    public function extractData(ExtractDataRequestInterface $request): \Generator;
}
