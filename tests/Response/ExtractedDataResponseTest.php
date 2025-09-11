<?php

namespace OneToMany\PDFAI\Tests\Response;

use OneToMany\PDFAI\Contract\Enum\OutputType;
use OneToMany\PDFAI\Response\ExtractedDataResponse;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function base64_encode;
use function file_get_contents;

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

        $page = \random_int(2, 100);
        $this->assertGreaterThan($response->getPage(), $page);

        $response->setPage($page);
        $this->assertEquals($page, $response->getPage());
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
