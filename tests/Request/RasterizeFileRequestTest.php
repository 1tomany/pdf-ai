<?php

namespace OneToMany\PdfToImage\Tests\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;
use OneToMany\PdfToImage\Request\RasterizeFileRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function random_int;

use const PHP_INT_MAX;

#[Group('UnitTests')]
#[Group('RequestTests')]
final class RasterizeFileRequestTest extends TestCase
{
    private ?string $filePath = null;

    protected function setUp(): void
    {
        $this->filePath = __DIR__.'/files/label.pdf';
    }

    public function testConstructorRequiresNonEmptyPath(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The file path cannot be empty.');

        new RasterizeFileRequest('');
    }

    public function testConstructorRequiresReadableFile(): void
    {
        $filePath = __DIR__.'/invalid.file.path';
        $this->assertFileDoesNotExist($filePath);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The file path "'.$filePath.'" does not exist or is not readable.');

        new RasterizeFileRequest($filePath);
    }

    public function testConstructorRequiresPositiveNonZeroFirstPage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The first page number must be a positive non-zero integer.');

        new RasterizeFileRequest($this->filePath, firstPage: 0);
    }

    public function testConstructorRequiresPositiveNonZeroLastPage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The last page number must be a positive non-zero integer.');

        new RasterizeFileRequest($this->filePath, lastPage: 0);
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMinimumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The resolution must be an integer between '.RasterizeFileRequestInterface::MIN_RESOLUTION.' and '.RasterizeFileRequestInterface::MAX_RESOLUTION.'.');

        new RasterizeFileRequest($this->filePath, resolution: random_int(1, RasterizeFileRequestInterface::MIN_RESOLUTION - 1));
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMaximumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The resolution must be an integer between '.RasterizeFileRequestInterface::MIN_RESOLUTION.' and '.RasterizeFileRequestInterface::MAX_RESOLUTION.'.');

        new RasterizeFileRequest($this->filePath, resolution: random_int(RasterizeFileRequestInterface::MAX_RESOLUTION + 1, PHP_INT_MAX));
    }

    #[DataProvider('providerConstructorArguments')]
    public function testConstructor(
        string $filePath,
        int $firstPage,
        int $lastPage,
        ImageType $outputType,
        int $resolution,
    ): void {
        $request = new RasterizeFileRequest($filePath, $firstPage, $lastPage, $outputType, $resolution);

        $this->assertEquals($filePath, $request->getFilePath());
        $this->assertEquals($firstPage, $request->getFirstPage());
        $this->assertEquals($lastPage, $request->getLastPage());
        $this->assertEquals($outputType, $request->getOutputType());
        $this->assertEquals($resolution, $request->getResolution());
    }

    /**
     * @return list<list<int|string|ImageType>>
     */
    public static function providerConstructorArguments(): array
    {
        $resolution = random_int(
            RasterizeFileRequestInterface::MIN_RESOLUTION,
            RasterizeFileRequestInterface::MAX_RESOLUTION,
        );

        $provider = [
            [__DIR__.'/files/label.pdf', 1, 1, ImageType::Png, $resolution],
            [__DIR__.'/files/label.pdf', 2, 4, ImageType::Jpg, $resolution],
        ];

        return $provider;
    }

    public function testSettingFirstPageGreaterThanLastPageClampsLastPageToFirstPage(): void
    {
        $request = new RasterizeFileRequest($this->filePath);
        $this->assertEquals($request->getFirstPage(), $request->getLastPage());

        $firstPage = $request->getFirstPage() + 1;
        $this->assertGreaterThan($request->getLastPage(), $firstPage);

        $request->setFirstPage($firstPage);
        $this->assertEquals($request->getFirstPage(), $request->getLastPage());
    }

    public function testSettingLastPageLessThanLastFirstClampsFirstPageToLastPage(): void
    {
        $page = random_int(2, 10);

        $request = new RasterizeFileRequest($this->filePath, $page, $page);
        $this->assertEquals($request->getLastPage(), $request->getFirstPage());

        $lastPage = $request->getLastPage() - 1;
        $this->assertLessThan($request->getFirstPage(), $lastPage);

        $request->setLastPage($lastPage);
        $this->assertEquals($request->getLastPage(), $request->getFirstPage());
    }
}
