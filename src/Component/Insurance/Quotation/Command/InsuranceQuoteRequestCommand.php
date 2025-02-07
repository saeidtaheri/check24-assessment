<?php

namespace App\Component\Insurance\Quotation\Command;

use App\Component\Insurance\Provider\InsuranceProvider;
use App\Component\Insurance\Provider\InsuranceProviderFactory;
use App\Component\Insurance\Quotation\Exception\ValidationException;
use App\Component\Insurance\Quotation\Generator\Output;
use App\Component\Insurance\Quotation\Generator\GeneratorFactory;
use App\Component\Insurance\Quotation\InsuranceRequest;
use App\Component\Insurance\Quotation\Reader\Input;
use App\Component\Insurance\Quotation\Reader\ReaderFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use function PHPUnit\Framework\fileExists;

final class InsuranceQuoteRequestCommand extends Command
{
    public function __construct(
        private readonly GeneratorFactory         $generatorFactory,
        private readonly ReaderFactory            $readerFactory,
        private readonly InsuranceProviderFactory $providerFactory,
        private readonly KernelInterface          $kernel,
        ?string                                   $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('insurance:quote')
            ->setDescription('Sends the quote request to insurance provider')
            ->addArgument('provider', InputArgument::REQUIRED, 'Insurance provider name.')
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'Input file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fileExtension = pathinfo($input->getOption('file'), PATHINFO_EXTENSION);
        $filePath = $this->kernel->getProjectDir() . $input->getOption('file');

        if (!fileExists($filePath)) {
            $output->writeln('<error>File does not exist');
            return self::FAILURE;
        }

        $data = $this->readerFactory
            ->make(Input::from(strtoupper($fileExtension)))
            ->readFromFile($filePath);

        try {
            $insuranceRequest = InsuranceRequest::fromArray($data);
        } catch (ValidationException $e) {
            foreach ($e->getViolations() as $violation) {
                $output->writeln(sprintf(
                    '<error>%s</error>',
                    $violation->getMessage()
                ));
            }
            return Command::FAILURE;
        }

        $insuranceProvider = $this->providerFactory
            ->make(InsuranceProvider::from($input->getArgument('provider')));

        $insuranceProvider->submit(
            $insuranceRequest,
            $this->generatorFactory->make(Output::XML)
        );

        $output->writeln('<info>Send request successfully proceed');

        return Command::SUCCESS;
    }
}