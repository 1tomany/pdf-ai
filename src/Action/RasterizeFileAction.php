<?php

namespace OneToMany\PdfToImage\Action;

use OneToMany\PdfToImage\Contract\Action\RasterizeFileActionInterface;
use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

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
