<?php

namespace OneToMany\PdfToImage\Contract\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;

interface RasterizePDFRequestInterface
{
    /**
     * @return non-empty-string
     */
    public function getFilePath(): string;

    /**
     * @return positive-int
     */
    public function getFirstPage(): int;

    /**
     * @return positive-int
     */
    public function getLastPage(): int;

    public function getOutputType(): ImageType;

    /**
     * @return int<self::MIN_RESOLUTION, self::MAX_RESOLUTION>
     */
    public function getResolution(): int;

    public const int DEFAULT_RESOLUTION = 72;
    public const int MIN_RESOLUTION = 48;
    public const int MAX_RESOLUTION = 300;
}
