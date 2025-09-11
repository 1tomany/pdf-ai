<?php

namespace OneToMany\PDFAI\Tests\Response;

use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Response\ExtractedDataResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Type\ObjectType;

use function base64_encode;
use function file_get_contents;
use function random_int;

#[Group('UnitTests')]
#[Group('ResponseTests')]
final class ExtractedDataResponseTest extends TestCase
{
    public function testToString(): void
    {
        $text = 'Hello, world!';

        $this->assertEquals($text, new ExtractedDataResponse(OutputType::Txt, $text)->__toString());
    }

    public function testSettingPageClampsNonPositiveNonZeroValuesToOne(): void
    {
        $response = new ExtractedDataResponse(
            OutputType::Txt, 'Response', 1,
        );

        $this->assertEquals(1, $response->getPage());

        $response->setPage(0);
        $this->assertEquals(1, $response->getPage());

        $response->setPage(-10);
        $this->assertEquals(1, $response->getPage());

        $page = random_int(2, 100);
        $this->assertGreaterThan($response->getPage(), $page);

        $response->setPage($page);
        $this->assertEquals($page, $response->getPage());
    }

    #[DataProvider('providerGettingName')]
    public function testGettingName(OutputType $type, int $page, string $name): void
    {
        $this->assertEquals($name, new ExtractedDataResponse($type, 'Response', $page)->getName());
    }

    public static function providerGettingName(): array
    {
        $page = \random_int(1, 100);

        $provider = [
            [OutputType::Jpg, $page, "page-{$page}.jpeg"],
            [OutputType::Png, $page, "page-{$page}.png"],
            [OutputType::Txt, $page, "page-{$page}.txt"],
        ];

        return $provider;
    }

    public function testToDataUri(): void
    {
        $filePath = __DIR__.'/files/page.png';
        $this->assertFileExists($filePath);

        $data = file_get_contents($filePath);

        $this->assertIsString($data);
        $this->assertNotEmpty($data);

        $dataUri = 'data:image/png;base64,'.base64_encode($data);
        $this->assertEquals($dataUri, new ExtractedDataResponse(OutputType::Png, $data)->toDataUri());
    }
}
