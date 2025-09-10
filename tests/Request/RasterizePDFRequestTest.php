<?php

namespace OneToMany\PdfToImage\Tests\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizePDFRequestInterface;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;
use OneToMany\PdfToImage\Request\RasterizePDFRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function random_int;

use const PHP_INT_MAX;

#[Group('UnitTests')]
#[Group('RequestTests')]
final class RasterizePDFRequestTest extends TestCase
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

        new RasterizePDFRequest('');
    }

    public function testConstructorRequiresReadableFile(): void
    {
        $filePath = __DIR__.'/invalid.file.path';
        $this->assertFileDoesNotExist($filePath);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The file path "'.$filePath.'" does not exist or is not readable.');

        new RasterizePDFRequest($filePath);
    }

    public function testConstructorRequiresPositiveNonZeroFirstPageNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The first page number must be a positive non-zero integer.');

        new RasterizePDFRequest($this->filePath, startPage: 0);
    }

    // public function testConstructorRequiresFirstPageNumberToBeLessThanOrEqualToLastPageNumber(): void
    // {
    //     $this->expectException(InvalidArgumentException::class);
    //     $this->expectExceptionMessage('The first page number cannot be greater than the last page number.');

    //     new RasterizePDFRequest(filePath: __FILE__, startPage: 2, lastPage: 1);
    // }

    public function testConstructorRequiresPositiveNonZeroLastPageNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The last page number must be a positive non-zero integer.');

        new RasterizePDFRequest($this->filePath, lastPage: 0);
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMinimumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The resolution must be an integer between '.RasterizePDFRequestInterface::MIN_RESOLUTION.' and '.RasterizePDFRequestInterface::MAX_RESOLUTION.'.');

        new RasterizePDFRequest($this->filePath, resolution: random_int(1, RasterizePDFRequestInterface::MIN_RESOLUTION-1));
    }

    public function testConstructorRequiresResolutionToBeLessThanOrEqualToMaximumResolution(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The resolution must be an integer between '.RasterizePDFRequestInterface::MIN_RESOLUTION.' and '.RasterizePDFRequestInterface::MAX_RESOLUTION.'.');

        new RasterizePDFRequest($this->filePath, resolution: random_int(RasterizePDFRequestInterface::MAX_RESOLUTION+1, PHP_INT_MAX));
    }

    #[DataProvider('providerRequest')]
    public function testConstructor(
        string $filePath,
        int $firstPage,
        int $lastPage,
        ImageType $outputType,
        int $resolution,
    ): void {
        $request = new RasterizePDFRequest(
            $filePath,
            $firstPage,
            $lastPage,
            $outputType,
            $resolution,
        );

        $this->assertEquals($filePath, $request->getFilePath());
        $this->assertEquals($firstPage, $request->getFirstPage());
        $this->assertEquals($lastPage, $request->getLastPage());
        $this->assertEquals($outputType, $request->getOutputType());
        $this->assertEquals($resolution, $request->getResolution());
    }

    /**
     * @return list<list<int|string|ImageType>>
     */
    public static function providerRequest(): array
    {
        $resolution = random_int(
            RasterizePDFRequestInterface::MIN_RESOLUTION,
            RasterizePDFRequestInterface::MAX_RESOLUTION,
        );

        $provider = [
            [__DIR__.'/files/label.pdf', 1, 1, ImageType::Png, $resolution],
            [__DIR__.'/files/label.pdf', 2, 4, ImageType::Jpg, $resolution],
        ];

        return $provider;
    }

    public function testSettingFirstPageGreaterThanLastPageClampsLastPageToFirstPage(): void
    {
        $request = new RasterizePDFRequest($this->filePath);
        $this->assertEquals($request->getFirstPage(), $request->getLastPage());

        $firstPage = $request->getFirstPage() + 1;
        $this->assertGreaterThan($request->getLastPage(), $firstPage);

        $request->setFirstPage($firstPage);
        $this->assertEquals($request->getFirstPage(), $request->getLastPage());
    }

    public function testSettingLastPageLessThanLastFirstClampsFirstPageToLastPage(): void
    {
        $page = random_int(2, 10);

        $request = new RasterizePDFRequest($this->filePath, $page, $page);
        $this->assertEquals($request->getLastPage(), $request->getFirstPage());

        $lastPage = $request->getLastPage() - 1;
        $this->assertLessThan($request->getFirstPage(), $lastPage);

        $request->setLastPage($lastPage);
        $this->assertEquals($request->getLastPage(), $request->getFirstPage());
    }
}
