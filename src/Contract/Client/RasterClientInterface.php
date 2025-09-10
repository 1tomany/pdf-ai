<?php

namespace OneToMany\PdfToImage\Contract\Client;

use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

interface RasterClientInterface
{
    public function readInfo(ReadFileRequestInterface $request): PdfInfoResponseInterface;

    public function rasterize(RasterizeFileRequestInterface $request): ImageResponseInterface;
}
