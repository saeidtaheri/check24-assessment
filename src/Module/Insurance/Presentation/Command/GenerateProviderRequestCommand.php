<?php

namespace App\Module\Insurance\Presentation\Command;

use App\Module\Insurance\Application\Exceptions\InvalidFileException;
use App\Module\Insurance\Application\Exceptions\ValidationException;
use App\Module\Insurance\Application\Services\CustomerInputFactory;
use App\Module\Insurance\Application\Services\InsuranceProviderRequestFactory;
use App\Module\Insurance\Domain\Customer\Entities\CustomerInput;
use App\Module\Insurance\Domain\Enums\InputType;
use App\Module\Insurance\Domain\Enums\OutputType;
use App\Module\Insurance\Domain\Insurer\Entities\InsuranceProviderRequest;
use App\Module\Insurance\Infrastructure\Generators\GeneratorFactory;
use App\Module\Insurance\Infrastructure\Readers\ReaderFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

final class GenerateProviderRequestCommand extends Command
{
    public function __construct(
        private readonly KernelInterface                 $kernel,
        private readonly ReaderFactory                   $readerFactory,
        private readonly GeneratorFactory                $generatorFactory,
        private readonly CustomerInputFactory            $customerInputFactory,
        private readonly InsuranceProviderRequestFactory $insuranceProviderRequestFactory,
        ?string                                          $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('insurance:generate-provider-request')
            ->setDescription('Generates insurance provider request base on the customer input')
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'InputType file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $customerInput = $this->parseCustomerInput($input, $output);

        if (!$customerInput instanceof CustomerInput) {
            return Command::FAILURE;
        }

        $providerRequest = $this->mapCustomerInputToProviderRequest($customerInput, $output);

        $result = $this->generatorFactory
            ->make(OutputType::XML)
            ->generate($providerRequest);

        $output->writeln($result);

        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return CustomerInput|int
     */
    public function parseCustomerInput(InputInterface $input, OutputInterface $output): CustomerInput|int
    {
        $fileExtension = pathinfo($input->getOption('file'), PATHINFO_EXTENSION);
        $filePath = $this->kernel->getProjectDir() . $input->getOption('file');

        try {
            $customerInputArray = $this->readerFactory
                ->make(InputType::from(strtoupper($fileExtension)))
                ->readFromFile($filePath);

            return $this->customerInputFactory->createFromArray($customerInputArray);
        } catch (InvalidFileException $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            return Command::FAILURE;
        } catch (ValidationException $e) {
            foreach ($e->getViolations() as $violation) {
                $output->writeln(sprintf(
                    '<error>%s</error>',
                    $violation->getMessage()
                ));
            }
            return Command::FAILURE;
        }
    }

    /**
     * @param CustomerInput $customerInput
     * @param OutputInterface $output
     * @return InsuranceProviderRequest|int
     */
    private function mapCustomerInputToProviderRequest(
        CustomerInput   $customerInput,
        OutputInterface $output
    ): InsuranceProviderRequest|int
    {
        try {
            return $this->insuranceProviderRequestFactory
                ->createFromCustomerInput($customerInput);
        } catch (ValidationException $e) {
            foreach ($e->getViolations() as $violation) {
                $output->writeln(sprintf(
                    '<error>%s</error>',
                    $violation->getMessage()
                ));
            }
            return Command::FAILURE;
        }
    }
}