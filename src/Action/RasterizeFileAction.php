<?php

namespace OneToMany\PdfExtractor\Action;

use OneToMany\PdfExtractor\Contract\Action\RasterizeFileActionInterface;
use OneToMany\PdfExtractor\Contract\Client\PdfExtractorClientInterface;
use OneToMany\PdfExtractor\Contract\Request\ExtractPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ExtractedDataResponseInterface;

final readonly class RasterizeFileAction implements RasterizeFileActionInterface
{
    public function __construct(private PdfExtractorClientInterface $client)
    {
    }

    public function act(ExtractPdfRequestInterface $request): ExtractedDataResponseInterface
    {
        return $this->client->extract($request);
    }
}
