<?php

namespace App\Tests\Component\Insurance\Quotation\Command;


use App\Component\Insurance\Provider\InsuranceProviderFactory;
use App\Component\Insurance\Quotation\Command\InsuranceQuoteRequestCommand;
use App\Component\Insurance\Quotation\Generator\GeneratorFactory;
use App\Component\Insurance\Quotation\Reader\ReaderFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

class InsuranceQuoteRequestCommandTest extends TestCase
{
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        $kernel = $this->createMock(KernelInterface::class);
        $kernel->method('getProjectDir')->willReturn('/srv/www/');

        $readerFactory = new ReaderFactory();
        $generatorFactory = new GeneratorFactory();
        $providerFactory = new InsuranceProviderFactory();

        $command = new InsuranceQuoteRequestCommand(
            $generatorFactory,
            $readerFactory,
            $providerFactory,
            $kernel
        );

        $application = new Application();
        $application->add($command);
        $this->commandTester = new CommandTester($command);
    }

    public function test_it_should_proceed_with_valid_input()
    {
        $this->commandTester->execute([
            'provider' => 'ACME',
            '--file' => '/tests/Unit/Component/Insurance/Quotation/Command/artifacts/valid.json',
        ]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Send request successfully proceed', $output);
    }


    /**
     * @dataProvider DataProvider
     */
    public function test_it_should_throw_exception_with_invalid_json_file(string $filePath, string $errorMessage)
    {
        $this->expectException(\Exception::class);

        $this->commandTester->execute([
            'provider' => 'ACME',
            '--file' => $filePath,
        ]);

        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString($errorMessage, $output);
    }

    public function DataProvider(): \Generator
    {
        yield 'invalid json file' => [
            'filePath' =>  '/tests/Unit/Component/Insurance/Quotation/Command/artifacts/invalid-json-file.json',
            'message' => 'Can not read the file:'
        ];

        yield 'missing file' => [
            'filePath' =>  '/tests/Unit/Component/Insurance/Quotation/Command/artifacts/missing-file.json',
            'message' => 'File not found'
        ];
    }
}