<?php

namespace OneToMany\PDFExtractor\Response;

use OneToMany\PDFExtractor\Contract\Enum\OutputType;
use OneToMany\PDFExtractor\Contract\Response\ExtractedDataResponseInterface;

use function base64_encode;
use function max;
use function sprintf;
use function trim;

class ExtractedDataResponse implements ExtractedDataResponseInterface
{
    /**
     * @param positive-int $page
     */
    public function __construct(
        protected OutputType $type,
        protected string $data,
        protected int $page = 1,
    ) {
        $this->setType($type);
        $this->setData($data);
        $this->setPage($page);
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

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): static
    {
        $this->page = max(1, $page);

        return $this;
    }

    public function toDataUri(): string
    {
        return sprintf('data:%s;base64,%s', $this->type->getMimeType(), base64_encode($this->data));
    }
}
