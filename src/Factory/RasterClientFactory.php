<?php

namespace OneToMany\PdfExtractor\Factory;

use OneToMany\PdfExtractor\Contract\Client\RasterClientInterface;
use OneToMany\PdfExtractor\Factory\Exception\CreatingRasterClientFailedServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final readonly class RasterClientFactory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function create(string $id): RasterClientInterface
    {
        try {
            $service = $this->container->get($id);

            if (!$service instanceof RasterClientInterface) {
                throw new CreatingRasterClientFailedServiceNotFoundException($id);
            }
        } catch (ContainerExceptionInterface $e) {
            throw new CreatingRasterClientFailedServiceNotFoundException($id, $e);
        }

        return $service;
    }
}
