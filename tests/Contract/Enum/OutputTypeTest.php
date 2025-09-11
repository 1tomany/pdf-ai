<?php

namespace OneToMany\PDFAI\Tests\Contract\Enum;

use OneToMany\PDFAI\Contract\Enum\OutputType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

#[Group('UnitTests')]
#[Group('ContractTests')]
#[Group('EnumTests')]
final class OutputTypeTest extends TestCase
{
    #[DataProvider('providerGettingExtension')]
    public function testGettingExtension(OutputType $type, string $extension): void
    {
        $this->assertEquals($extension, $type->getExtension());
    }

    /**
     * @return list<list<non-empty-string|OutputType>>
     */
    public static function providerGettingExtension(): array
    {
        $provider = [
            [OutputType::Jpg, 'jpeg'],
            [OutputType::Png, 'png'],
            [OutputType::Txt, 'txt'],
        ];

        return $provider;
    }

}
