<?php

namespace OneToMany\PDFExtractor\Action;

use OneToMany\PDFExtractor\Contract\Action\ExtractDataActionInterface;
use OneToMany\PDFExtractor\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFExtractor\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\ExtractedDataResponseInterface;

final readonly class ExtractDataAction implements ExtractDataActionInterface
{
    public function __construct(private ExtractorClientInterface $client)
    {
    }

    public function act(ExtractDataRequestInterface $request): ExtractedDataResponseInterface
    {
        return $this->client->extractData($request);
    }
}
