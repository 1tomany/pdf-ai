<?php

namespace OneToMany\PdfExtractor\Contract\Client;

use OneToMany\PdfExtractor\Contract\Request\ExtractPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;

interface PdfExtractorClientInterface
{
    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface;

    public function extract(ExtractPdfRequestInterface $request): ExtractedDataResponseInterface;
}
