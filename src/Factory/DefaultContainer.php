<?php

namespace OneToMany\PDFAI\Factory;

use OneToMany\PDFAI\Client\Poppler\PopplerExtractorClient;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function sprintf;

class DefaultContainer implements ContainerInterface
{
    private ?PopplerExtractorClient $popplerClient = null;

    public function get(string $id): mixed
    {
        if ('poppler' !== $id) {
            throw new class(sprintf('The extractor client "%s" could not be found.', $id)) extends \InvalidArgumentException implements NotFoundExceptionInterface { };
        }

        $this->popplerClient ??= new PopplerExtractorClient();

        return $this->popplerClient;
    }

    public function has(string $id): bool
    {
        return 'poppler' === $id;
    }
}
