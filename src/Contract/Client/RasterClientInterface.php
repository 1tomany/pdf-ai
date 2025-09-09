<?php

namespace OneToMany\PdfToImage\Contract\Client;

use OneToMany\PdfToImage\Contract\Request\RasterizeRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadInfoRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

interface RasterClientInterface
{
    public function readInfo(ReadInfoRequestInterface $request): PdfInfoResponseInterface;

    public function rasterize(RasterizeRequestInterface $request): ImageResponseInterface;
}
