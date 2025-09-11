<?php

namespace OneToMany\PDFExtractor\Contract\Request;

interface ReadMetadataRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;
}
