<?php

namespace OneToMany\PdfExtractor\Contract\Action;

use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;

interface ReadFileActionInterface
{
    public function act(ReadPdfRequestInterface $request): PdfInfoResponseInterface;
}
