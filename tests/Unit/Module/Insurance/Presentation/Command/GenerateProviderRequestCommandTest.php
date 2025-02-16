<?php

namespace App\Tests\Unit\Module\Insurance\Presentation\Command;

use App\Module\Insurance\Application\Exceptions\InvalidFileException;
use App\Module\Insurance\Application\Services\CustomerInputFactory;
use App\Module\Insurance\Application\Services\InsuranceProviderRequestFactory;
use App\Module\Insurance\Infrastructure\Generators\GeneratorFactory;
use App\Module\Insurance\Infrastructure\Readers\ReaderFactory;
use App\Module\Insurance\Presentation\Command\GenerateProviderRequestCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

class GenerateProviderRequestCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = $this->createMock(KernelInterface::class);
        $kernel->method('getProjectDir')->willReturn('/srv/www/');

        $readerFactory = new ReaderFactory();
        $generatorFactory = new GeneratorFactory();
        $customerInputFactory = new CustomerInputFactory();
        $insuranceProviderRequestFactory = new InsuranceProviderRequestFactory();

        $command = new GenerateProviderRequestCommand(
            $kernel,
            $readerFactory,
            $generatorFactory,
            $customerInputFactory,
            $insuranceProviderRequestFactory,
        );

        $application = new Application();
        $application->add($command);
        $this->commandTester = new CommandTester($command);
    }

    public function test_it_should_generate_xml_result_with_valid_input()
    {
        $this->commandTester->execute([
            '--file' => '/tests/Unit/Module/Insurance/Presentation/Command/artifacts/valid.json',
        ]);

        $output = $this->commandTester->getDisplay();

        $sampleOutput = '<?xml version="1.0" encoding="UTF-8"?>
            <TarificacionThirdPartyRequest>
              <Datos>
                <DatosConductor>
                  <CondPpalEsTomador>YES</CondPpalEsTomador>
                  <ConductorUnico>NO</ConductorUnico>
                  <FecCot>2025-02-16</FecCot>
                  <AnosSegAnte>8</AnosSegAnte>
                  <NroCondOca>0</NroCondOca>
                  <SeguroEnVigor>NO</SeguroEnVigor>
                </DatosConductor>
              </Datos>
            </TarificacionThirdPartyRequest>';

        $this->assertXmlStringEqualsXmlString($sampleOutput, $output);
    }

    /**
     * @dataProvider InvalidDataProvider
     */
    public function test_it_should_throw_exception_with_invalid_file(string $filePath, string $errorMessage)
    {
        $this->commandTester->execute([
            '--file' => $filePath,
        ]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString($errorMessage, $output);
    }

    public function InvalidDataProvider(): \Generator
    {
        yield 'invalid json file' => [
            'filePath' =>  '/tests/Unit/Module/Insurance/Presentation/Command/artifacts/invalid.json',
            'message' => 'Can not read the file'
        ];

        yield 'invalid json data' => [
            'filePath' =>  '/tests/Unit/Module/Insurance/Presentation/Command/artifacts/invalid-data-file.json',
            'message' => 'Driver BirthDate must be valid date.'
        ];

        yield 'missing file' => [
            'filePath' =>  'tests/Unit/Module/Insurance/Presentation/Command/artifacts/missing-file.json',
            'message' => 'File not found'
        ];
    }
}