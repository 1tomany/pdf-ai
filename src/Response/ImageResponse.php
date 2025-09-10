<?php

namespace OneToMany\PdfToImage\Response;

use OneToMany\PdfToImage\Contract\Enum\OutputType;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;

use function base64_encode;
use function sprintf;
use function trim;

class ImageResponse implements ImageResponseInterface
{
    protected OutputType $type;
    protected string $data;

    public function __construct(
        OutputType $type,
        string $data,
    ) {
        $this->setType($type);
        $this->setData($data);
    }

    public function __toString(): string
    {
        return $this->data;
    }

    public function getType(): OutputType
    {
        return $this->type;
    }

    public function setType(OutputType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(?string $data): static
    {
        $this->data = trim($data ?? '');

        return $this;
    }

    public function toDataUri(): string
    {
        return sprintf('data:%s;base64,%s', $this->type->getMimeType(), base64_encode($this->data));
    }
}
