<?php

namespace OneToMany\PDFExtractor\Action;

use OneToMany\PDFExtractor\Contract\Action\ReadMetadataActionInterface;
use OneToMany\PDFExtractor\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFExtractor\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\MetadataResponseInterface;

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
