<?php

namespace OneToMany\PdfToImage\Client\Mock;

use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\RasterizeRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadInfoRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfToImage\Exception\RuntimeException;
use OneToMany\PdfToImage\Response\PdfInfoResponse;

readonly class MockRasterClient implements RasterClientInterface
{
    public function __construct()
    {
    }

    public function readInfo(ReadInfoRequestInterface $request): PdfInfoResponseInterface
    {
        return new PdfInfoResponse(\random_int(1, 100));
    }

    public function rasterize(RasterizeRequestInterface $request): ImageResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
