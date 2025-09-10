<?php

namespace OneToMany\PdfExtractor\Client\Mock;

use OneToMany\PdfExtractor\Contract\Client\PdfExtractorClientInterface;
use OneToMany\PdfExtractor\Contract\Request\ExtractPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfExtractor\Exception\RuntimeException;
use OneToMany\PdfExtractor\Response\FileResponse;

use function random_int;

readonly class MockRasterClient implements PdfExtractorClientInterface
{
    public function __construct()
    {
    }

    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface
    {
        return new FileResponse(random_int(1, 100));
    }

    public function extract(ExtractPdfRequestInterface $request): ExtractedDataResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
