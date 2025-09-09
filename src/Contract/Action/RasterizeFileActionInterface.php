<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\RasterizeRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(RasterizeRequestInterface $request): ImageResponseInterface;
}
