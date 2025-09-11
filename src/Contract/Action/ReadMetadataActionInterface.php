<?php

namespace OneToMany\PDFAI\Contract\Action;

use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFAI\Contract\Response\MetadataResponseInterface;

interface ReadMetadataActionInterface
{
    public function act(ReadMetadataRequestInterface $request): MetadataResponseInterface;
}
