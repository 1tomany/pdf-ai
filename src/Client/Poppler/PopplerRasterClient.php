<?php

namespace OneToMany\PdfToImage\Client\Poppler;

use OneToMany\PdfToImage\Client\Exception\ReadingPdfInfoFailedException;
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
        $process = new Process([$this->binary, $request->getPath()]);

        try {
            $info = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new ReadingPdfInfoFailedException($request->getPath(), $process->getErrorOutput(), $e);
        }

        $response = new PdfInfoResponse();

        foreach (\explode("\n", $info) as $infoBit) {
            if (\str_contains($infoBit, ':')) {
                $bits = \explode(':', $infoBit);

                if (0 === \strcmp('Pages', $bits[0])) {
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
            $imageTypeArg = match ($request->getType()) {
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
                $request->getPath(),
            ]);

        try {
            $image = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new RasterizingPdfFailedException($request->getPath(), $request->getPage(), $process->getErrorOutput(), $e);
        }

        // return new RasterData($request->type, $image);
        */
    }
}
