<?php

namespace OneToMany\PdfExtractor\Contract\Response;

use OneToMany\PdfExtractor\Contract\Enum\OutputType;

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
