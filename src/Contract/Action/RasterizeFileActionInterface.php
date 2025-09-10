<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(RasterizeFileRequestInterface $request): ImageResponseInterface;
}
