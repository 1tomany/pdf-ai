<?php

namespace OneToMany\PdfToImage\Client\Exception;

use function sprintf;

final class ReadingPdfInfoFailedException extends BinaryProcessFailedException
{
    public function __construct(string $file, ?string $error = null, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Failed to read the info for the file "%s".', $file), $error, $previous);
    }
}
