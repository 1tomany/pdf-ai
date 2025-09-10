<?php

namespace OneToMany\PdfToImage\Contract\Enum;

enum ImageType
{
    case Jpg;
    case Png;

    public function getMimeType(): string
    {
        $mimeType = match ($this) {
            self::Jpg => 'image/jpeg',
            self::Png => 'image/png',
        };

        return $mimeType;
    }

    public function isJpg(): bool
    {
        return self::Jpg === $this;
    }

    public function isPng(): bool
    {
        return self::Png === $this;
    }
}
