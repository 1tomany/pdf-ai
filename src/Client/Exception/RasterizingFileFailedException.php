<?php

namespace OneToMany\PDFExtractor\Client\Exception;

use function sprintf;

final class RasterizingFileFailedException extends BinaryProcessFailedException
{
    public function __construct(string $filePath, int $pageNumber, ?string $error = null, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Rasterizing page %d of the file "%s" failed.', $pageNumber, $filePath), $error, $previous);
    }
}
