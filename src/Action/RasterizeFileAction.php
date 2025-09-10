<?php

namespace OneToMany\PdfExtractor\Action;

use OneToMany\PdfExtractor\Contract\Action\RasterizeFileActionInterface;
use OneToMany\PdfExtractor\Contract\Client\RasterClientInterface;
use OneToMany\PdfExtractor\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ImageResponseInterface;

final readonly class RasterizeFileAction implements RasterizeFileActionInterface
{
    public function __construct(private RasterClientInterface $client)
    {
    }

    public function act(RasterizePdfRequestInterface $request): ImageResponseInterface
    {
        return $this->client->rasterize($request);
    }
}
