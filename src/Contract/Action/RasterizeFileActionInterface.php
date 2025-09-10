<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(RasterizePdfRequestInterface $request): ImageResponseInterface;
}
