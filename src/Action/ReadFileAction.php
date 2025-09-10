<?php

namespace OneToMany\PdfToImage\Action;

use OneToMany\PdfToImage\Contract\Action\ReadFileActionInterface;
use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\FileResponseInterface;

final readonly class ReadFileAction implements ReadFileActionInterface
{
    public function __construct(private RasterClientInterface $client)
    {
    }

    public function act(ReadFileRequestInterface $request): FileResponseInterface
    {
        return $this->client->read($request);
    }
}
