<?php

namespace OneToMany\PDFAI\Tests\Client\Poppler;

use OneToMany\PDFAI\Client\Exception\RasterizingFileFailedException;
use OneToMany\PDFAI\Client\Exception\ReadingFileFailedException;
use OneToMany\PDFAI\Client\Poppler\PopplerRasterClient;
use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Exception\InvalidArgumentException;
use OneToMany\PDFAI\Request\ExtractPdfRequest;
use OneToMany\PDFAI\Request\ReadPdfRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Large;
use PHPUnit\Framework\TestCase;

use function random_int;
use function sha1;

#[Large]
#[Group('UnitTests')]
#[Group('ClientTests')]
#[Group('PopplerTests')]
final class PopplerRasterClientTest extends TestCase
{
    public function testConstructorRequiresValidPdfInfoBinary(): void
    {
        $pdfInfoBinary = 'invalid_pdfinfo_binary';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The binary "'.$pdfInfoBinary.'" could not be found.');

        new PopplerRasterClient(pdfInfoBinary: $pdfInfoBinary);
    }

    public function testConstructorRequiresValidPdfToPpmBinary(): void
    {
        $pdfToPpmBinary = 'invalid_pdftoppm_binary';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The binary "'.$pdfToPpmBinary.'" could not be found.');

        new PopplerRasterClient(pdfToPpmBinary: $pdfToPpmBinary);
    }

    public function testReadingRequiresValidPdfFile(): void
    {
        $this->expectException(ReadingFileFailedException::class);
        $this->expectExceptionMessageMatches('/May not be a PDF file/');

        new PopplerRasterClient()->readMetadata(new ReadPdfRequest(__FILE__));
    }

    #[DataProvider('providerReadFileRequestArguments')]
    public function testReadingFile(string $filePath, int $pageCount): void
    {
        $this->assertEquals($pageCount, new PopplerRasterClient()->readMetadata(new ReadPdfRequest($filePath))->getPages());
    }

    /**
     * @return list<list<int|string|OutputType>>
     */
    public static function providerReadFileRequestArguments(): array
    {
        $provider = [
            [__DIR__.'/../files/pages-1.pdf', 1],
            [__DIR__.'/../files/pages-2.pdf', 2],
            [__DIR__.'/../files/pages-3.pdf', 3],
            [__DIR__.'/../files/pages-4.pdf', 4],
        ];

        return $provider;
    }

    public function testRasterizationRequiresValidPdfFile(): void
    {
        $this->expectException(RasterizingFileFailedException::class);
        $this->expectExceptionMessageMatches('/May not be a PDF file/');

        new PopplerRasterClient()->extractData(new ExtractPdfRequest(__FILE__));
    }

    public function testRasterizationRequiresValidPageNumber(): void
    {
        $pageNumber = random_int(2, 100);

        $this->expectException(RasterizingFileFailedException::class);
        $this->expectExceptionMessageMatches('/Wrong page range given/');

        new PopplerRasterClient()->extractData(new ExtractPdfRequest(__DIR__.'/../files/pages-1.pdf', $pageNumber, $pageNumber));
    }

    #[DataProvider('providerRasterizeFileRequestArguments')]
    public function testRasterizingFile(
        string $filePath,
        int $firstPage,
        int $lastPage,
        OutputType $outputType,
        int $resolution,
        string $sha1Hash,
    ): void {
        $request = new ExtractPdfRequest(
            $filePath,
            $firstPage,
            $lastPage,
            $outputType,
            $resolution,
        );

        $image = new PopplerRasterClient()->extractData($request);
        $this->assertEquals($sha1Hash, sha1($image->__toString()));
    }

    /**
     * @return list<list<int|string|OutputType>>
     */
    public static function providerRasterizeFileRequestArguments(): array
    {
        $provider = [
            [__DIR__.'/../files/pages-1.pdf', 1, 1, OutputType::Jpg, 150, 'bfbfea39b881befa7e0af249f4fff08592d1ff56'],
            [__DIR__.'/../files/pages-2.pdf', 1, 1, OutputType::Jpg, 300, 'b4f24570eaeda3bc0b2865e7583666ec9cae8cc3'],
            [__DIR__.'/../files/pages-2.pdf', 1, 1, OutputType::Png, 150, '73ee6b53e3c48945095da187be916593e2cbec17'],
            [__DIR__.'/../files/pages-3.pdf', 1, 1, OutputType::Jpg, 72, '932f94066020ae177c64544c6611441570dc2b50'],
            [__DIR__.'/../files/pages-4.pdf', 1, 1, OutputType::Png, 72, 'a074c43375569c0f8d1b24a9fc7dbc456b5c126d'],
        ];

        return $provider;
    }
}
