<?php

namespace OneToMany\PdfToImage\Client\Exception;

use function sprintf;

final class ReadingFileFailedException extends BinaryProcessFailedException
{
    public function __construct(string $filePath, ?string $error = null, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Reading the file "%s" failed.', $filePath), $error, $previous);
    }
}
