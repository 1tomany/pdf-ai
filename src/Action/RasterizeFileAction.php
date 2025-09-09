<?php

namespace OneToMany\PdfToImage\Action;

use OneToMany\PdfToImage\Record\RasterData;
use OneToMany\PdfToImage\Request\RasterizeRequest;
use OneToMany\PdfToImage\Service\RasterServiceInterface;

final readonly class RasterizeFileAction
{
    public function __construct(private RasterServiceInterface $rasterService)
    {
    }

    public function act(RasterizeRequest $request): RasterData
    {
        return $this->rasterService->rasterize($request);
    }
}
