<?php

namespace OneToMany\PDFAI\Action;

use OneToMany\PDFAI\Contract\Action\ExtractDataActionInterface;
use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;

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
