<?php

namespace OneToMany\PdfToImage\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizePDFRequestInterface;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;

use function is_file;
use function is_readable;
use function sprintf;
use function trim;

class RasterizePDFRequest implements RasterizePDFRequestInterface
{
    /**
     * @var non-empty-string
     */
    protected string $filePath;

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
        int $startPage = 1,
        int $lastPage = 1,
        ImageType $outputType = ImageType::Jpg,
        int $resolution = self::DEFAULT_RESOLUTION,
    ) {
        $this->setFilePath($filePath);
        $this->setFirstPage($startPage);
        $this->setLastPage($lastPage);
        $this->setOutputType($outputType);
        $this->setResolution($resolution);
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $filePath = trim($filePath ?? '') ?: null;

        if (empty($filePath)) {
            throw new InvalidArgumentException('The file path cannot be empty.');
        }

        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new InvalidArgumentException(sprintf('The file path "%s" does not exist or is not readable.', $filePath));
        }

        $this->filePath = $filePath;

        return $this;
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

        // if ($firstPage > $this->getLastPage()) {
        //     throw new InvalidArgumentException('The first page number cannot be greater than the last page number.');
        // }

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
