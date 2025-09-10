<?php

namespace OneToMany\PdfExtractor\Client\Mock;

use OneToMany\PdfExtractor\Contract\Client\RasterClientInterface;
use OneToMany\PdfExtractor\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ImageResponseInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfExtractor\Exception\RuntimeException;
use OneToMany\PdfExtractor\Response\FileResponse;

use function random_int;

readonly class MockRasterClient implements RasterClientInterface
{
    public function __construct()
    {
    }

    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface
    {
        return new FileResponse(random_int(1, 100));
    }

    public function rasterize(RasterizePdfRequestInterface $request): ImageResponseInterface
    {
        throw new RuntimeException('Not implemented!');
    }
}
