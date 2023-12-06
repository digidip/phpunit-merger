<?php

declare(strict_types=1);

namespace Nimut\PhpunitMerger\Tests\Command\Log;

use Nimut\PhpunitMerger\Command\LogCommand;
use Nimut\PhpunitMerger\Tests\Command\AbstractCommandTestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\OutputInterface;

class LogCommandTest extends AbstractCommandTestCase
{
    use ProphecyTrait;

    protected string $outputFile = 'log.xml';

    public function testRunMergesLogs()
    {
        $this->assertOutputFileNotExists();

        $input = new ArgvInput(
            [
                'log',
                __DIR__ . '/datasets/',
                $this->logDirectory . $this->outputFile,
            ]
        );
        $output = $this->getMockBuilder(OutputInterface::class)->getMock();

        $command = new LogCommand();
        $command->run($input, $output);

        $this->assertFileExists($this->logDirectory . $this->outputFile);
        self::assertXmlFileEqualsXmlFile(__DIR__ . '/expected_merge.xml', $this->logDirectory . $this->outputFile);
    }
}
