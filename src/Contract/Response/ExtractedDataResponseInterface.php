<?php

namespace OneToMany\PDFExtractor\Contract\Response;

use OneToMany\PDFExtractor\Contract\Enum\OutputType;

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
