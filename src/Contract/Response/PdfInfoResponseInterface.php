<?php

namespace OneToMany\PdfToImage\Contract\Response;

interface PdfInfoResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPages(): int;
}
