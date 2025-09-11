<?php

namespace OneToMany\PDFAI\Client\Poppler;

use OneToMany\PDFAI\Client\Exception\ExtractingDataFailedException;
use OneToMany\PDFAI\Client\Exception\ReadingMetadataFailedException;
use OneToMany\PDFAI\Contract\Client\ExtractorClientInterface;
use OneToMany\PDFAI\Contract\Request\ExtractDataRequestInterface;
use OneToMany\PDFAI\Contract\Request\ReadMetadataRequestInterface;
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
    public function __construct(
        private string $pdfInfoBinary = 'pdfinfo',
        private string $pdfToPpmBinary = 'pdftoppm',
        private string $pdfToTextBinary = 'pdftotext',
    ) {
    }

    public function readMetadata(ReadMetadataRequestInterface $request): MetadataResponseInterface
    {
        $process = new Process([BinaryFinder::find($this->pdfInfoBinary), $request->getFilePath()]);

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

    public function extractData(ExtractDataRequestInterface $request): \Generator
    {
        if ($request->getOutputType()->isTxt()) {
            $command = BinaryFinder::find($this->pdfToTextBinary);

            for ($page = $request->getFirstPage(); $page <= $request->getLastPage(); ++$page) {
                $process = new Process([$command, '-nodiag', '-f', $page, '-l', $page, '-r', $request->getResolution(), $request->getFilePath(), '-']);

                try {
                    $output = $process->mustRun()->getOutput();
                } catch (ProcessExceptionInterface $e) {
                    throw new ExtractingDataFailedException($request->getFilePath(), $page, $process->getErrorOutput(), $e);
                }

                yield new ExtractedDataResponse($request->getOutputType(), $output);
            }
        } else {
            $command = BinaryFinder::find($this->pdfToPpmBinary);

            for ($page = $request->getFirstPage(); $page <= $request->getLastPage(); ++$page) {
                $process = new Process([$command, $request->getOutputType()->isJpg() ? '-jpeg' : '-png', '-f', $page, '-l', $page, '-r', $request->getResolution(), $request->getFilePath()]);

                try {
                    $output = $process->mustRun()->getOutput();
                } catch (ProcessExceptionInterface $e) {
                    throw new ExtractingDataFailedException($request->getFilePath(), $page, $process->getErrorOutput(), $e);
                }

                yield new ExtractedDataResponse($request->getOutputType(), $output);
            }
        }
    }
}
