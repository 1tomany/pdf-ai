<?php

namespace OneToMany\PdfToImage\Contract\Action;

use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\FileResponseInterface;

interface ReadFileActionInterface
{
    public function act(ReadFileRequestInterface $request): FileResponseInterface;
}
