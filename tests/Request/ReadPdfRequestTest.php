<?php

namespace OneToMany\PdfExtractor\Tests\Request;

use OneToMany\PdfExtractor\Exception\InvalidArgumentException;
use OneToMany\PdfExtractor\Request\ReadPdfRequest;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('UnitTests')]
#[Group('RequestTests')]
final class ReadPdfRequestTest extends TestCase
{
    public function testConstructorRequiresReadableFile(): void
    {
        $filePath = __DIR__.'/invalid.file.path';
        $this->assertFileDoesNotExist($filePath);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The file path "'.$filePath.'" does not exist or is not readable.');

        new ReadPdfRequest($filePath);
    }
}
