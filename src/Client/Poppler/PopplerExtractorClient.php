<?php

namespace OneToMany\PDFAI\Client\Poppler;

use OneToMany\PDFAI\Client\Exception\ExtractingDataFailedException;
use OneToMany\PDFAI\Client\Exception\ReadingMetadataFailedException;
use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
use OneToMany\PDFAI\Contract\Response\ExtractedDataResponseInterface;
use OneToMany\PDFAI\Contract\Response\MetadataResponseInterface;
use OneToMany\PDFAI\Helper\BinaryFinder;
use OneToMany\PDFAI\Response\ExtractedDataResponse;
use OneToMany\PDFAI\Response\MetadataResponse;
use Symfony\Component\Process\Exception\ExceptionInterface as ProcessExceptionInterface;
use Symfony\Component\Process\Process;

use function explode;
use function str_contains;
use function strcmp;

readonly class PopplerExtractorClient implements ExtractorClientInterface
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

    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface
    {
        $process = new Process([$this->pdfInfoBinary, $request->getFilePath()]);

        try {
            $output = $process->mustRun()->getOutput();
        } catch (ProcessExceptionInterface $e) {
            throw new ReadingMetadataFailedException($request->getFilePath(), $process->getErrorOutput(), $e);
        }

        $response = new MetadataResponse();

        foreach (explode("\n", $output) as $infoBit) {
            if (str_contains($infoBit, ':')) {
                $bits = explode(':', $infoBit);

                if (0 === strcmp('Pages', $bits[0])) {
                    $response->setPages((int) $bits[1]);
                }
            }
        }

        return $response;
    }

    public function extractData(ExtractDataRequestInterface $request): ExtractedDataResponseInterface
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
            throw new ExtractingDataFailedException($request->getFilePath(), $request->getFirstPage(), $process->getErrorOutput(), $e);
        }

        return new ExtractedDataResponse($request->getOutputType(), $output);
    }
}
