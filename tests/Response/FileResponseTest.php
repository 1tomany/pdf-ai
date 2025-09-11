<?php

namespace OneToMany\PDFExtractor\Tests\Response;

use OneToMany\PDFExtractor\Response\FileResponse;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

use function random_int;

#[Group('UnitTests')]
#[Group('ResponseTests')]
final class FileResponseTest extends TestCase
{
    public function testSettingPageCountClampsNonPositiveNonZeroValuesToOne(): void
    {
        $this->assertEquals(1, new FileResponse()->setPageCount(-1 * random_int(1, 100))->getPageCount());
    }
}
