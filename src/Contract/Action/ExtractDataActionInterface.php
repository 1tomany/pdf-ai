<?php

namespace OneToMany\PDFAI\Contract\Action;

use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;

interface ExtractDataActionInterface
{
    public function act(ExtractDataRequestInterface $request): ExtractedDataResponseInterface;
}
