<?php

namespace OneToMany\PdfToImage\Response;

use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

use function max;

class PdfInfoResponse implements PdfInfoResponseInterface
{
    /**
     * @var positive-int
     */
    protected int $pages = 1;

    public function __construct(int $pages = 1)
    {
        $this->setPages($pages);
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function setPages(int $pages): static
    {
        $this->pages = max(1, $pages);

        return $this;
    }
}
