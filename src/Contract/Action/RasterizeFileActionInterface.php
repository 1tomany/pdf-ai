<?php

namespace OneToMany\PdfExtractor\Contract\Action;

use OneToMany\PdfExtractor\Contract\Request\ExtractPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\ExtractedDataResponseInterface;

interface RasterizeFileActionInterface
{
    public function act(ExtractPdfRequestInterface $request): ExtractedDataResponseInterface;
}
