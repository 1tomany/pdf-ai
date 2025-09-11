<?php

namespace OneToMany\PDFAI\Contract\Action;

use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;

interface ExtractDataActionInterface
{
    /**
     * @return \Generator<int, ExtractedDataResponseInterface>
     */
    public function act(ExtractDataRequestInterface $request): \Generator;
}
