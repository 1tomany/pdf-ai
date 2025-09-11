<?php

namespace OneToMany\PDFExtractor\Contract\Response;

interface MetadataResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPageCount(): int;
}
