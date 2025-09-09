<?php

namespace OneToMany\PdfToImage\Service;

use OneToMany\PdfToImage\Record\RasterData;
use OneToMany\PdfToImage\Request\RasterizeRequest;

final readonly class MockRasterService implements RasterServiceInterface
{
    /**
     * @see OneToMany\PdfToImage\RasterServiceInterface
     */
    public function rasterize(RasterizeRequest $request): RasterData
    {
        throw new \RuntimeException('Not implemented!');
    }
}
