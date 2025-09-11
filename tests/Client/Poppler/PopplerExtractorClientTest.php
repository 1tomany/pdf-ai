<?php

namespace OneToMany\PDFAI\Tests\Client\Poppler;

use OneToMany\PDFAI\Client\Exception\ExtractingDataFailedException;
use OneToMany\PDFAI\Client\Exception\ReadingMetadataFailedException;
use OneToMany\PDFAI\Client\Poppler\PopplerExtractorClient;
use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Exception\InvalidArgumentException;
use OneToMany\PDFAI\Request\ExtractDataRequest;
use OneToMany\PDFAI\Request\ExtractTextRequest;
use OneToMany\PDFAI\Request\ReadMetadataRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Large;
use PHPUnit\Framework\TestCase;

use function iterator_to_array;
use function random_int;

#[Large]
#[Group('UnitTests')]
#[Group('ClientTests')]
#[Group('PopplerTests')]
final class PopplerExtractorClientTest extends TestCase
{
    public function testReadingMetadataRequiresValidPdfInfoBinary(): void
    {
        $pdfInfoBinary = 'invalid_pdfinfo_binary';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The binary "'.$pdfInfoBinary.'" could not be found.');

        new PopplerExtractorClient(pdfInfoBinary: $pdfInfoBinary)->readMetadata(new ReadMetadataRequest(__FILE__));
    }

    public function testReadingMetadataRequiresValidPdfFile(): void
    {
        $this->expectException(ReadingMetadataFailedException::class);
        $this->expectExceptionMessageMatches('/May not be a PDF file/');

        new PopplerExtractorClient()->readMetadata(new ReadMetadataRequest(__FILE__));
    }

    #[DataProvider('providerReadMetadataRequestArguments')]
    public function testReadingMetadata(string $filePath, int $pages): void
    {
        $this->assertEquals($pages, new PopplerExtractorClient()->readMetadata(new ReadMetadataRequest($filePath))->getPages());
    }

    /**
     * @return list<list<int|string|OutputType>>
     */
    public static function providerReadMetadataRequestArguments(): array
    {
        $provider = [
            [__DIR__.'/../files/pages-1.pdf', 1],
            [__DIR__.'/../files/pages-2.pdf', 2],
            [__DIR__.'/../files/pages-3.pdf', 3],
            [__DIR__.'/../files/pages-4.pdf', 4],
        ];

        return $provider;
    }

    public function testExtractingImageDataRequiresValidPdfToPpmBinary(): void
    {
        $pdfToPpmBinary = 'invalid_pdftoppm_binary';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The binary "'.$pdfToPpmBinary.'" could not be found.');

        new PopplerExtractorClient(pdfToPpmBinary: $pdfToPpmBinary)->extractData(new ExtractDataRequest(__FILE__, outputType: OutputType::Jpg))->current();
    }

    public function testExtractingTextDataRequiresValidPdfToTextBinary(): void
    {
        $pdfToTextBinary = 'invalid_pdftotext_binary';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The binary "'.$pdfToTextBinary.'" could not be found.');

        new PopplerExtractorClient(pdfToTextBinary: $pdfToTextBinary)->extractData(new ExtractTextRequest(__FILE__))->current();
    }

    public function testExtractingDataRequiresValidPdfFile(): void
    {
        $this->expectException(ExtractingDataFailedException::class);
        $this->expectExceptionMessageMatches('/May not be a PDF file/');

        new PopplerExtractorClient()->extractData(new ExtractDataRequest(__FILE__))->current();
    }

    public function testExtractingDataRequiresValidPage(): void
    {
        $page = random_int(2, 100);

        $this->expectException(ExtractingDataFailedException::class);
        $this->expectExceptionMessageMatches('/Wrong page range given/');

        new PopplerExtractorClient()->extractData(new ExtractDataRequest(__DIR__.'/../files/pages-1.pdf', $page, $page))->current();
    }

    #[DataProvider('providerFilePathFirstPageLastPageAndResponseCount')]
    public function testExtractingDataExtractsCorrectRange(
        string $filePath,
        int $firstPage,
        int $lastPage,
        int $responseCount,
    ): void
    {
        $client = new PopplerExtractorClient();

        $request = new ExtractDataRequest(
            filePath: $filePath,
            firstPage: $firstPage,
            lastPage: $lastPage,
        );

        $this->assertCount($responseCount, iterator_to_array($client->extractData($request)));
    }

    /**
     * @return list<list<int|string>>
     */
    public static function providerFilePathFirstPageLastPageAndResponseCount(): array
    {
        $provider = [
            [__DIR__.'/../files/pages-1.pdf', 1, 1, 1],
            [__DIR__.'/../files/pages-2.pdf', 1, 1, 1],
            [__DIR__.'/../files/pages-2.pdf', 2, 2, 1],
            [__DIR__.'/../files/pages-2.pdf', 1, 2, 2],
            [__DIR__.'/../files/pages-3.pdf', 1, 1, 1],
            [__DIR__.'/../files/pages-3.pdf', 1, 2, 2],
            [__DIR__.'/../files/pages-3.pdf', 2, 2, 1],
            [__DIR__.'/../files/pages-3.pdf', 2, 3, 2],
            [__DIR__.'/../files/pages-3.pdf', 1, 3, 3],
            [__DIR__.'/../files/pages-3.pdf', 3, 3, 1],
            [__DIR__.'/../files/pages-4.pdf', 1, 4, 4],
        ];

        return $provider;
    }

    #[DataProvider('providerExtractingTextData')]
    public function testExtractingTextData(string $filePath, int $page, string $expectedText): void
    {
        $client = new PopplerExtractorClient();

        $request = new ExtractTextRequest($filePath, $page, $page);
        $responses = iterator_to_array($client->extractData($request));

        $this->assertCount(1, $responses);
        print_r($responses[0]);
    }

    public static function providerExtractingTextData(): array
    {
        $provider = [
            // [__DIR__.'/../files/pages-1.pdf', 1, ''],
            [__DIR__.'/../files/pages-2.pdf', 2, ''],
            // [__DIR__.'/../files/pages-2.pdf', 1, 1, 1],
            // [__DIR__.'/../files/pages-2.pdf', 2, 2, 1],
            // [__DIR__.'/../files/pages-2.pdf', 1, 2, 2],
            // [__DIR__.'/../files/pages-3.pdf', 1, 1, 1],
            // [__DIR__.'/../files/pages-3.pdf', 1, 2, 2],
            // [__DIR__.'/../files/pages-3.pdf', 2, 2, 1],
            // [__DIR__.'/../files/pages-3.pdf', 2, 3, 2],
            // [__DIR__.'/../files/pages-3.pdf', 1, 3, 3],
            // [__DIR__.'/../files/pages-3.pdf', 3, 3, 1],
            // [__DIR__.'/../files/pages-4.pdf', 1, 4, 4],
        ];

        return $provider;
    }
}
