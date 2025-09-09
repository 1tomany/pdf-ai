<?php

namespace OneToMany\PdfToImage\Contract\Request;

interface ReadInfoRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getPath(): string;
}
