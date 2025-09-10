<?php

namespace OneToMany\PdfExtractor\Action;

use OneToMany\PdfExtractor\Contract\Action\RasterizeFileActionInterface;
use OneToMany\PdfExtractor\Contract\Client\RasterClientInterface;
use OneToMany\PdfExtractor\Contract\Request\ExtractPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ExtractedDataResponseInterface;

final readonly class RasterizeFileAction implements RasterizeFileActionInterface
{
    public function __construct(private RasterClientInterface $client)
    {
    }

    public function act(ExtractPdfRequestInterface $request): ExtractedDataResponseInterface
    {
        return $this->client->rasterize($request);
    }
}
