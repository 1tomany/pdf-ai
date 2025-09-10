<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\RasterizePDFRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(RasterizePDFRequestInterface $request): ImageResponseInterface;
}
