<?php

namespace OneToMany\PdfToImage\Contract\Response;

interface FileResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPageCount(): int;
}
