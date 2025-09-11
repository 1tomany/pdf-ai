<?php

namespace OneToMany\PDFAI\Action;

use OneToMany\PDFAI\Contract\Action\ReadMetadataActionInterface;
use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFAI\Contract\Response\MetadataResponseInterface;

final readonly class ReadMetadataAction implements ReadMetadataActionInterface
{
    public function __construct(private ExtractorClientInterface $client)
    {
    }

    public function act(ReadMetadataRequestInterface $request): MetadataResponseInterface
    {
        return $this->client->readMetadata($request);
    }
}
