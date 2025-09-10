<?php

namespace OneToMany\PdfExtractor\Factory\Exception;

use OneToMany\PdfExtractor\Exception\RuntimeException;

use function sprintf;

final class CreatingRasterClientFailedServiceNotFoundException extends RuntimeException
{
    public function __construct(string $service, ?\Throwable $previous = null)
    {
        parent::__construct(sprintf('Creating a client for the raster service "%s" failed because a service with that tag could not be found.', $service), previous: $previous);
    }
}
