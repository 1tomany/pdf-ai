<?php

namespace OneToMany\PDFAI\Request;

use OneToMany\PDFAI\Contract\Enum\OutputType;

class RasterizePageRequest extends ExtractDataRequest
{
    public function __construct(
        ?string $filePath,
        int $pageNumber = 1,
        OutputType $outputType = OutputType::Jpg,
        int $resolution = self::DEFAULT_RESOLUTION,
    ) {
        parent::__construct($filePath, $pageNumber, $pageNumber, $outputType, $resolution);
    }
}
