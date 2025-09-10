<?php

namespace OneToMany\PdfToImage\Action;

use OneToMany\PdfToImage\Contract\Action\ReadFileActionInterface;
use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;

final readonly class ReadFileAction implements ReadFileActionInterface
{
    public function __construct(private RasterClientInterface $client)
    {
    }

    public function act(ReadPdfRequestInterface $request): PdfInfoResponseInterface
    {
        return $this->client->read($request);
    }
}
