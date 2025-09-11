<?php

namespace OneToMany\PDFExtractor\Contract\Action;

use OneToMany\PDFExtractor\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFExtractor\Contract\Response\MetadataResponseInterface;

interface ReadMetadataActionInterface
{
    public function act(ReadMetadataRequestInterface $request): MetadataResponseInterface;
}
