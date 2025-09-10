<?php

namespace OneToMany\PdfToImage\Client\Mock;

use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\FileResponseInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Exception\RuntimeException;
use OneToMany\PdfToImage\Response\FileResponse;

use function random_int;

readonly class MockRasterClient implements RasterClientInterface
{
    public function __construct()
    {
    }

    public function read(ReadFileRequestInterface $request): FileResponseInterface
    {
        return new FileResponse(random_int(1, 100));
    }

    public function rasterize(RasterizeFileRequestInterface $request): ImageResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
