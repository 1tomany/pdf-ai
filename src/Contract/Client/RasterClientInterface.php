<?php

namespace OneToMany\PdfExtractor\Contract\Client;

use OneToMany\PdfExtractor\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfExtractor\Contract\Response\ImageResponseInterface;

interface RasterClientInterface
{
    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface;

    public function rasterize(RasterizePdfRequestInterface $request): ImageResponseInterface;
}
