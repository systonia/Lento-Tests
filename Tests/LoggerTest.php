<?php

use Lento\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Lento\Models\LoggerOptions;

class DummyLogger implements LoggerInterface
{
    public array $logs = [];

    public function log($level, $message, array $context = []): void
    {
        $this->logs[] = [$level, $message, $context];
    }

    public function emergency(Stringable|string $message, array $context = []): void {}
    public function alert(Stringable|string $message, array $context = []): void {}
    public function critical(Stringable|string $message, array $context = []): void {}
    public function error(Stringable|string $message, array $context = []): void {}
    public function warning(Stringable|string $message, array $context = []): void {}
    public function notice(Stringable|string $message, array $context = []): void {}
    public function info(Stringable|string $message, array $context = []): void {}
    public function debug(Stringable|string $message, array $context = []): void {}
}

class LoggerTest extends TestCase
{
    protected function setUp(): void
    {
        Logger::clear();
    }

    public function testLoggerReceivesCorrectLevels()
    {
        $logger = new DummyLogger();
        Logger::add($logger, [LogLevel::ERROR, LogLevel::WARNING]);

        Logger::error('error msg', ['err' => 1]);
        Logger::warning('warning msg');
        Logger::info('info msg');
        Logger::debug('debug msg');

        $this->assertCount(2, $logger->logs);
        $this->assertEquals([LogLevel::ERROR, 'error msg', ['err' => 1]], $logger->logs[0]);
        $this->assertEquals([LogLevel::WARNING, 'warning msg', []], $logger->logs[1]);
    }

    public function testLoggerAcceptsAllLevelsByDefault()
    {
        $logger = new DummyLogger();
        Logger::add($logger); // No levels, accepts all

        Logger::info('info');
        Logger::debug('debug');

        $this->assertCount(2, $logger->logs);
        $this->assertEquals(LogLevel::INFO, $logger->logs[0][0]);
        $this->assertEquals(LogLevel::DEBUG, $logger->logs[1][0]);
    }

    public function testLoggerWithAssocOptions()
    {
        $logger = new DummyLogger();
        Logger::add($logger, ['levels' => [LogLevel::ALERT], 'name' => 'special']);

        Logger::alert('alert msg');
        Logger::info('should not log');

        $this->assertCount(1, $logger->logs);
        $this->assertEquals([LogLevel::ALERT, 'alert msg', []], $logger->logs[0]);
    }

    public function testNullLoggerFallback()
    {
        // No logger registered: should use NullLogger (which does nothing, but also doesn't error)
        Logger::clear();
        Logger::info('test msg');
        $this->assertTrue(true, 'No exception thrown, fallback works');
    }

    public function testClearRemovesLoggers()
    {
        $logger = new DummyLogger();
        Logger::add($logger);
        Logger::clear();
        Logger::info('no logger now');
        $this->assertCount(0, $logger->logs, 'Logger was cleared and not called');
    }
}
