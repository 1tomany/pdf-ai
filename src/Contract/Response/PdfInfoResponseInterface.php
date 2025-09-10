<?php

namespace OneToMany\PdfToImage\Contract\Response;

interface PdfInfoResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPageCount(): int;
}
