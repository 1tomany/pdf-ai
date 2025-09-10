<?php

namespace OneToMany\PdfToImage\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;

use function sprintf;

class RasterizeFileRequest extends ReadFileRequest implements RasterizeFileRequestInterface
{
    /**
     * @var positive-int
     */
    protected int $firstPage = 1;

    /**
     * @var positive-int
     */
    protected int $lastPage = 1;
    protected ImageType $outputType = ImageType::Jpg;

    /**
     * @var int<self::MIN_RESOLUTION, self::MAX_RESOLUTION>
     */
    protected int $resolution = self::DEFAULT_RESOLUTION;

    public function __construct(
        ?string $filePath,
        int $firstPage = 1,
        int $lastPage = 1,
        ImageType $outputType = ImageType::Jpg,
        int $resolution = self::DEFAULT_RESOLUTION,
    ) {
        $this->setFilePath($filePath);
        $this->setFirstPage($firstPage);
        $this->setLastPage($lastPage);
        $this->setOutputType($outputType);
        $this->setResolution($resolution);
    }

    public function getFirstPage(): int
    {
        return $this->firstPage;
    }

    public function setFirstPage(int $firstPage): static
    {
        if ($firstPage < 1) {
            throw new InvalidArgumentException('The first page number must be a positive non-zero integer.');
        }

        $this->firstPage = $firstPage;

        if ($firstPage > $this->getLastPage()) {
            $this->setLastPage($firstPage);
        }

        return $this;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function setLastPage(int $lastPage): static
    {
        if ($lastPage < 1) {
            throw new InvalidArgumentException('The last page number must be a positive non-zero integer.');
        }

        if ($lastPage < $this->getFirstPage()) {
            $this->setFirstPage($lastPage);
        }

        $this->lastPage = $lastPage;

        return $this;
    }

    public function getOutputType(): ImageType
    {
        return $this->outputType;
    }

    public function setOutputType(ImageType $outputType): static
    {
        $this->outputType = $outputType;

        return $this;
    }

    public function getResolution(): int
    {
        return $this->resolution;
    }

    public function setResolution(int $resolution): static
    {
        if ($resolution < self::MIN_RESOLUTION || $resolution > self::MAX_RESOLUTION) {
            throw new InvalidArgumentException(sprintf('The resolution must be an integer between %d and %d.', self::MIN_RESOLUTION, self::MAX_RESOLUTION));
        }

        $this->resolution = $resolution;

        return $this;
    }
}
