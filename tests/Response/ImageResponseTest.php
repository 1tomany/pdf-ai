<?php

namespace OneToMany\PdfToImage\Tests\Response;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Response\ImageResponse;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function base64_encode;
use function file_get_contents;

#[Group('UnitTests')]
#[Group('ResponseTests')]
final class ImageResponseTest extends TestCase
{
    public function testToString(): void
    {
        $text = 'Hello, world!';

        $this->assertEquals($text, new ImageResponse(ImageType::Jpg, $text)->__toString());
    }

    public function testToDataUri(): void
    {
        $filePath = __DIR__.'/files/page.png';
        $this->assertFileExists($filePath);

        $data = file_get_contents($filePath);

        $this->assertIsString($data);
        $this->assertNotEmpty($data);

        $dataUri = 'data:image/png;base64,'.base64_encode($data);
        $this->assertEquals($dataUri, new ImageResponse(ImageType::Png, $data)->toDataUri());
    }
}
