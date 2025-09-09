<?php

namespace OneToMany\PdfToImage\Service;

use OneToMany\PdfToImage\Record\RasterData;
use OneToMany\PdfToImage\Request\RasterizeRequest;

interface RasterServiceInterface
{
    public function rasterize(RasterizeRequest $request): RasterData;
}
