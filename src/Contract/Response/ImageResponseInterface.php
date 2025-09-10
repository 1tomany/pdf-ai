<?php

namespace OneToMany\PdfToImage\Contract\Response;

use OneToMany\PdfToImage\Contract\Enum\ImageType;

interface ImageResponseInterface extends \Stringable
{
    public function getType(): ImageType;

    public function getData(): string;

    public function toDataUri(): string;
}
