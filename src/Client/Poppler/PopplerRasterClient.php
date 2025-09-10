<?php

namespace OneToMany\PdfToImage\Client\Poppler;

use OneToMany\PdfToImage\Client\Exception\RasterizingFileFailedException;
use OneToMany\PdfToImage\Client\Exception\ReadingFileFailedException;
use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizeFileRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadFileRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\FileResponseInterface;
use OneToMany\PdfToImage\Helper\BinaryFinder;
use OneToMany\PdfToImage\Response\ImageResponse;
use OneToMany\PdfToImage\Response\FileResponse;
use Symfony\Component\Process\Exception\ExceptionInterface as ProcessExceptionInterface;
use Symfony\Component\Process\Process;

use function explode;
use function str_contains;
use function strcmp;

readonly class PopplerRasterClient implements RasterClientInterface
{
    private string $pdfInfoBinary;
    private string $pdfToPpmBinary;

    public function __construct(
        string $pdfInfoBinary = 'pdfinfo',
        string $pdfToPpmBinary = 'pdftoppm',
    )
    {
        $this->pdfInfoBinary = BinaryFinder::find($pdfInfoBinary);
        $this->pdfToPpmBinary = BinaryFinder::find($pdfToPpmBinary);
    }

    public function read(ReadFileRequestInterface $request): FileResponseInterface
    {
        $process = new Process([$this->pdfInfoBinary, $request->getFilePath()]);

        try {
            $output = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new ReadingFileFailedException($request->getFilePath(), $process->getErrorOutput(), $e);
        }

        $response = new FileResponse();

        foreach (explode("\n", $output) as $infoBit) {
            if (str_contains($infoBit, ':')) {
                $bits = explode(':', $infoBit);

                if (0 === strcmp('Pages', $bits[0])) {
                    $response->setPageCount((int) $bits[1]);
                }
            }
        }

        return $response;
    }

    public function rasterize(RasterizeFileRequestInterface $request): ImageResponseInterface
    {
        $imageType = match ($request->getOutputType()) {
            ImageType::Jpg => '-jpeg',
            ImageType::Png => '-png',
        };

        $process = new Process([
            $this->pdfToPpmBinary,
            '-q',
            $imageType,
            '-f',
            $request->getFirstPage(),
            '-l',
            $request->getLastPage(),
            '-r',
            $request->getResolution(),
            $request->getFilePath(),
        ]);

        try {
            $output = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new RasterizingFileFailedException($request->getFilePath(), $request->getFirstPage(), $process->getErrorOutput(), $e);
        }

        return new ImageResponse($request->getOutputType(), $output);
    }
}
