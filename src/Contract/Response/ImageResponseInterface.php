<?php

namespace OneToMany\PdfToImage\Contract\Response;

use OneToMany\PdfToImage\Contract\Enum\OutputType;

interface ImageResponseInterface extends \Stringable
{
    public function getType(): OutputType;

    public function getData(): string;

    /**
     * @return positive-int
     */
    public function getPageNumber(): int;

    public function toDataUri(): string;
}
