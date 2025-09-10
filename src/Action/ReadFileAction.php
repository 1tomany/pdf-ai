<?php

namespace OneToMany\PdfExtractor\Action;

use OneToMany\PdfExtractor\Contract\Action\ReadFileActionInterface;
use OneToMany\PdfExtractor\Contract\Client\RasterClientInterface;
use OneToMany\PdfExtractor\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfExtractor\Contract\Response\PdfInfoResponseInterface;

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
