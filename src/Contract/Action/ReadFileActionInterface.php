<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

interface ReadFileActionInterface
{
    public function act(ReadPdfRequestInterface $request): PdfInfoResponseInterface;
}
