<?php

namespace OneToMany\PdfExtractor\Contract\Response;

interface PdfInfoResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPageCount(): int;
}
