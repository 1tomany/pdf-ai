<?php

namespace OneToMany\PDFExtractor\Contract\Action;

use OneToMany\PDFExtractor\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\ExtractedDataResponseInterface;

interface ExtractDataActionInterface
{
    public function act(ExtractDataRequestInterface $request): ExtractedDataResponseInterface;
}
