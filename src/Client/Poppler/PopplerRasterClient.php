<?php

namespace OneToMany\PdfToImage\Client\Poppler;

use OneToMany\PdfToImage\Contract\Client\RasterClientInterface;
use OneToMany\PdfToImage\Contract\Enum\ImageType;
use OneToMany\PdfToImage\Contract\Request\RasterizeRequestInterface;
use OneToMany\PdfToImage\Contract\Request\ReadInfoRequestInterface;
use OneToMany\PdfToImage\Contract\Response\ImageResponseInterface;
use OneToMany\PdfToImage\Contract\Response\PdfInfoResponseInterface;
use OneToMany\PdfToImage\Exception\RuntimeException;
use OneToMany\PdfToImage\Helper\BinaryFinder;
use OneToMany\PdfToImage\Response\PdfInfoResponse;
use Symfony\Component\Process\Exception\ExceptionInterface as ProcessExceptionInterface;
use Symfony\Component\Process\Process;

readonly class PopplerRasterClient implements RasterClientInterface
{
    private string $binary;

    public function __construct(string $binary = 'pdftoppm')
    {
        $this->binary = BinaryFinder::find($binary);
    }

    public function readInfo(ReadInfoRequestInterface $request): PdfInfoResponseInterface
    {
        $response = new PdfInfoResponse();

        try {
            $info = new Process([$this->binary, $request->getPath()])->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            // throw new ReadingPdfMetadataFailedException($path, isset($process) ? $process->getErrorOutput() : null, $e);
        }

        foreach (explode("\n", $info) as $infoBit) {
            if (str_contains($infoBit, ':')) {
                $bits = explode(':', $infoBit);

                if (0 === strcmp('Pages', $bits[0])) {
                    $response->setPages((int) $bits[1]);
                }
            }
        }

        return $response;
    }

    public function rasterize(RasterizeRequestInterface $request): ImageResponseInterface
    {
        throw new RuntimeException('Not implemented!');
        /*
        try {
            $imageTypeArg = match ($request->type) {
                ImageType::Jpg => '-jpeg',
                ImageType::Png => '-png',
            };

            $process = new Process([
                $this->binary,
                '-q',
                $imageTypeArg,
                '-f',
                $request->getPage(),
                '-l',
                $request->getPage(),
                '-r',
                $request->getDPI(),
                $request->getPage(),
            ]);

            $image = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new RasterizingPdfFailedException($request->path, $request->page, isset($process) ? $process->getErrorOutput() : null, $e);
        }

        // return new RasterData($request->type, $image);
        */
    }
}
