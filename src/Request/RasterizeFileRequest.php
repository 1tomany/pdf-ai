<?php

namespace OneToMany\PdfToImage\Request;

use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Exception\InvalidArgumentException;

use function is_file;
use function is_readable;
use function sprintf;
use function trim;

class RasterizeFileRequest implements RasterizeFileRequestInterface
{
    /**
     * @var non-empty-string
     */
    protected string $path;

    /**
     * @var positive-int
     */
    protected int $page = 1;
    protected ImageType $type = ImageType::Jpg;

    /**
     * @var int<48, 300>
     */
    protected int $dpi = 72;

    public const int MIN_DPI = 48;
    public const int MAX_DPI = 300;

    public function __construct(
        ?string $path,
        int $page = 1,
        ImageType $type = ImageType::Jpg,
        int $dpi = 72,
    ) {
        $this->setPath($path);
        $this->setPage($page);
        $this->setType($type);
        $this->setDPI($dpi);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $path = trim($path ?? '') ?: null;

        if (empty($path)) {
            throw new InvalidArgumentException('The path to the input file cannot be empty.');
        }

        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf('The input file path "%s" does not exist or is not readable.', $path));
        }

        $this->path = $path;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): static
    {
        if ($page < 1) {
            throw new InvalidArgumentException('The page number must be a positive non-zero integer.');
        }

        $this->page = $page;

        return $this;
    }

    public function getType(): ImageType
    {
        return $this->type;
    }

    public function setType(ImageType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDPI(): int
    {
        return $this->dpi;
    }

    public function setDPI(int $dpi): static
    {
        if ($dpi < self::MIN_DPI || $dpi > self::MAX_DPI) {
            throw new InvalidArgumentException(sprintf('The DPI must be an integer between %d and %d.', self::MIN_DPI, self::MAX_DPI));
        }

        $this->dpi = $dpi;

        return $this;
    }
}
