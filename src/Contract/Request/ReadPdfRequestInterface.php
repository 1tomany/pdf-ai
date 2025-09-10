<?php

namespace OneToMany\PdfExtractor\Contract\Request;

interface ReadPdfRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;
}
