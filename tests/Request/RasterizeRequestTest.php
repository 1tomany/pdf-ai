<?php

namespace OneToMany\PdfToImage\Tests\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;
use OneToMany\PdfToImage\Request\RasterizeRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function random_int;

use const PHP_INT_MAX;

#[Group('UnitTests')]
#[Group('RequestTests')]
final class RasterizeRequestTest extends TestCase
{
    public function testConstructorRequiresNonEmptyPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The path to the input file cannot be empty.');

        new RasterizeRequest('');
    }

    public function testConstructorRequiresReadableFile(): void
    {
        $path = __DIR__.'/invalid.file.path';
        $this->assertFileDoesNotExist($path);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The input file path "'.$path.'" does not exist or is not readable.');

        new RasterizeRequest($path);
    }

    public function testConstructorRequiresPositivePageNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The page number must be a positive non-zero integer.');

        new RasterizeRequest(path: __FILE__, page: 0);
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMinimumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The DPI must be an integer between 48 and 300.');

        new RasterizeRequest(path: __FILE__, dpi: random_int(1, 47));
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMaximumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The DPI must be an integer between 48 and 300.');

        new RasterizeRequest(path: __FILE__, dpi: random_int(301, PHP_INT_MAX));
    }

    #[DataProvider('providerRequest')]
    public function testConstructor(
        string $path,
        int $page,
        ImageType $type,
        int $dpi,
    ): void {
        $request = new RasterizeRequest($path, $page, $type, $dpi);

        $this->assertEquals($path, $request->getPath());
        $this->assertEquals($page, $request->getPage());
        $this->assertEquals($type, $request->getType());
        $this->assertEquals($dpi, $request->getDPI());
    }

    /**
     * @return list<list<int|string>>
     */
    public static function providerRequest(): array
    {
        $provider = [
            [__DIR__.'/files/label.pdf', 1, ImageType::Png, random_int(48, 300)],
        ];

        return $provider;
    }
}
