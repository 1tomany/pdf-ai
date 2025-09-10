<?php

namespace OneToMany\PdfToImage\Contract\Client;

use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\FileResponseInterface;

interface RasterClientInterface
{
    public function read(ReadFileRequestInterface $request): FileResponseInterface;

    public function rasterize(RasterizeFileRequestInterface $request): ImageResponseInterface;
}
