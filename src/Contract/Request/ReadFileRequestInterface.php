<?php

namespace OneToMany\PdfToImage\Contract\Request;

interface ReadFileRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;
}
