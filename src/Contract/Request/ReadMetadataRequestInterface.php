<?php

namespace OneToMany\PDFAI\Contract\Request;

interface ReadMetadataRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;
}
