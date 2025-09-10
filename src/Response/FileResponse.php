<?php

namespace OneToMany\PdfToImage\Response;

use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

use function max;

class FileResponse implements PdfInfoResponseInterface
{
    /**
     * @var positive-int
     */
    protected int $pageCount = 1;

    public function __construct(int $pageCount = 1)
    {
        $this->setPageCount($pageCount);
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): static
    {
        $this->pageCount = max(1, $pageCount);

        return $this;
    }
}
