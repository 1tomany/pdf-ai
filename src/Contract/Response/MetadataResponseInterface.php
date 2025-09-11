<?php

namespace OneToMany\PDFAI\Contract\Response;

interface MetadataResponseInterface
{
    /**
     * @return positive-int
     */
    public function getPages(): int;
}
