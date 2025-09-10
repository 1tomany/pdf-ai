<?php

namespace OneToMany\PdfExtractor\Tests\Factory;

use OneToMany\PdfExtractor\Client\Mock\MockRasterClient;
use OneToMany\PdfExtractor\Factory\Exception\CreatingRasterClientFailedServiceNotFoundException;
use OneToMany\PdfExtractor\Factory\RasterClientFactory;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[Group('UnitTests')]
#[Group('FactoryTests')]
final class RasterClientFactoryTest extends TestCase
{
    public function testCreatingServiceRequiresServiceToExist(): void
    {
        $this->expectException(CreatingRasterClientFailedServiceNotFoundException::class);

        new RasterClientFactory($this->createContainer())->create('invalid');
    }

    public function testCreatingServiceRequiresServiceToImplementRasterServiceInterface(): void
    {
        $this->expectException(CreatingRasterClientFailedServiceNotFoundException::class);

        new RasterClientFactory($this->createContainer())->create('error');
    }

    private function createContainer(): ContainerInterface
    {
        $container = new class implements ContainerInterface {
            /**
             * @var array{
             *   mock: MockRasterClient,
             *   error: \InvalidArgumentException,
             * }
             */
            private array $services;

            public function __construct()
            {
                $this->services = [
                    'mock' => new MockRasterClient(),
                    'error' => new \InvalidArgumentException(),
                ];
            }

            public function get(string $id): mixed
            {
                return $this->services[$id] ?? null;
            }

            public function has(string $id): bool
            {
                return isset($this->services[$id]);
            }
        };

        return $container;
    }
}
