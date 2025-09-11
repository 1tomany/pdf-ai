<?php

namespace OneToMany\PDFAI\Factory;

use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Factory\Exception\CreatingRasterClientFailedServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final readonly class ExtractorClientFactory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function create(string $id): ExtractorClientInterface
    {
        try {
            $service = $this->container->get($id);

            if (!$service instanceof ExtractorClientInterface) {
                throw new CreatingRasterClientFailedServiceNotFoundException($id);
            }
        } catch (ContainerExceptionInterface $e) {
            throw new CreatingRasterClientFailedServiceNotFoundException($id, $e);
        }

        return $service;
    }
}
