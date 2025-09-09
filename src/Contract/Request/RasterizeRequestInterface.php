<?php

namespace OneToMany\PdfToImage\Contract\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;

interface RasterizeRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getPath(): string;

    /**
     * @return positive-int
     */
    public function getPage(): int;

    public function getType(): ImageType;

    /**
     * @return int<48, 300>
     */
    public function getDPI(): int;
}
