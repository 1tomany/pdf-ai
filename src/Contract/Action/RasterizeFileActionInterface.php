<?php

namespace OneToMany\PdfExtractor\Contract\Action;

use OneToMany\PdfExtractor\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ImageResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(RasterizePdfRequestInterface $request): ImageResponseInterface;
}
