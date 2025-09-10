<?php

namespace OneToMany\PdfToImage\Client\Poppler;

use OneToMany\PdfToImage\Client\Exception\RasterizingFileFailedException;
use OneToMany\PdfToImage\Client\Exception\ReadingFileFailedException;
use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Request\RasterizePdfRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadPdfRequestInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Helper\BinaryFinder;
use OneToMany\PdfToImage\Response\FileResponse;
use OneToMany\PdfToImage\Response\ImageResponse;
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
    ) {
        $this->pdfInfoBinary = BinaryFinder::find($pdfInfoBinary);
        $this->pdfToPpmBinary = BinaryFinder::find($pdfToPpmBinary);
    }

    public function read(ReadPdfRequestInterface $request): PdfInfoResponseInterface
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

    public function rasterize(RasterizePdfRequestInterface $request): ImageResponseInterface
    {
        $process = new Process([
            $this->pdfToPpmBinary,
            $request->getOutputType()->isJpg() ? '-jpeg' : '-png',
            '-f',
            $request->getFirstPage(),
            '-l',
            $request->getFirstPage(),
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
