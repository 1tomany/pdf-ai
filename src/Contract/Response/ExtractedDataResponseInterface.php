<?php

namespace OneToMany\PdfExtractor\Contract\Response;

use OneToMany\PdfExtractor\Contract\Enum\OutputType;

interface ExtractedDataResponseInterface extends \Stringable
{
    public function getType(): OutputType;

    public function getData(): string;

    /**
     * @return positive-int
     */
    public function getPage(): int;

    public function toDataUri(): string;
}
