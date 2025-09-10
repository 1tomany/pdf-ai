<?php

namespace OneToMany\PdfToImage\Contract\Client;

use OneToMany\PdfToImage\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

interface RasterClientInterface
{
    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface;

    public function rasterize(RasterizePdfRequestInterface $request): ImageResponseInterface;
}
