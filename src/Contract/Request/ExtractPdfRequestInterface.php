<?php

namespace OneToMany\PdfExtractor\Contract\Request;

use OneToMany\PdfExtractor\Contract\Enum\OutputType;

interface ExtractPdfRequestInterface extends ReadPdfRequestInterface
{
    public const int DEFAULT_RESOLUTION = 72;
    public const int MIN_RESOLUTION = 48;
    public const int MAX_RESOLUTION = 300;

    /**
     * @return positive-int
     */
    public function getFirstPage(): int;

    /**
     * @return positive-int
     */
    public function getLastPage(): int;

    public function getOutputType(): OutputType;

    /**
     * @return int<self::MIN_RESOLUTION, self::MAX_RESOLUTION>
     */
    public function getResolution(): int;
}
