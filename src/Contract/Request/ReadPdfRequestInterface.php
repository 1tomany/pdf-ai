<?php

namespace OneToMany\PdfToImage\Contract\Request;

interface ReadPdfRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;
}
