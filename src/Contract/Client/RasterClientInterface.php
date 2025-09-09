<?php

namespace OneToMany\PdfToImage\Contract\Client;

use OneToMany\PdfToImage\Contract\Request\RasterizeRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

// use OneToMany\PdfToImage\Record\RasterData;
// use OneToMany\PdfToImage\Request\RasterizeFileRequest;

interface RasterClientInterface
{
    public function rasterize(RasterizeRequestInterface $request): ImageResponseInterface;
}
