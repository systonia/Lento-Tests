<?php

use PHPUnit\Framework\TestCase;
use Lento\Env;

final class EnvTest extends TestCase
{
    private string $tempDir;
    private array $oldEnv;
    private array $oldServer;

    protected function setUp(): void
    {
        // Backup environment
        $this->oldEnv = $_ENV;
        $this->oldServer = $_SERVER;

        // Create a temp directory for .env files
        $this->tempDir = sys_get_temp_dir() . '/envtest_' . uniqid();
        mkdir($this->tempDir);

        // Clean env variables that might conflict
        unset($_ENV['FOO'], $_SERVER['FOO'], $_ENV['BAR'], $_SERVER['BAR'], $_ENV['APP_ENV'], $_SERVER['APP_ENV']);
        putenv('FOO');
        putenv('BAR');
        putenv('APP_ENV');
        unset($_SERVER['SERVER_NAME']);
    }

    protected function tearDown(): void
    {
        // Remove the temp directory and files
        array_map('unlink', glob("$this->tempDir/.env*"));
        rmdir($this->tempDir);

        // Restore previous env/server arrays
        $_ENV = $this->oldEnv;
        $_SERVER = $this->oldServer;
        putenv('FOO');
        putenv('BAR');
        putenv('APP_ENV');
    }

    public function testLoadBaseEnvFile()
    {
        file_put_contents("$this->tempDir/.env", "FOO=bar\nBAR=qux\n");

        Env::load($this->tempDir);

        $this->assertEquals('bar', $_ENV['FOO']);
        $this->assertEquals('qux', $_ENV['BAR']);
        $this->assertEquals('bar', $_SERVER['FOO']);
        $this->assertEquals('qux', $_SERVER['BAR']);
        $this->assertEquals('bar', getenv('FOO'));
        $this->assertEquals('qux', getenv('BAR'));
    }

    public function testLoadEnvSpecificFile()
    {
        file_put_contents("$this->tempDir/.env", "FOO=main\n");
        file_put_contents("$this->tempDir/.env.development", "FOO=dev\nBAR=devbar\n");

        $_ENV['APP_ENV'] = 'development';
        $_SERVER['APP_ENV'] = 'development';

        Env::load($this->tempDir);

        $this->assertEquals('main', $_ENV['FOO']); // Main value should stick, unless env file is loaded first.
        $this->assertEquals('devbar', $_ENV['BAR']);
        $this->assertEquals('development', $_ENV['APP_ENV']);
    }

    public function testLoadMissingEnvFileDoesNotError()
    {
        // Directory exists, but no .env file
        Env::load($this->tempDir);
        $this->assertTrue(true); // Should not throw
    }

    public function testParseFileSkipsBlankCommentInvalidLines()
    {
        file_put_contents("$this->tempDir/.env", "
# This is a comment

INVALIDLINE
FOO=realvalue
");

        Env::load($this->tempDir);
        $this->assertEquals('realvalue', $_ENV['FOO']);
        $this->assertArrayNotHasKey('INVALIDLINE', $_ENV);
    }

    public function testEnvSpecificFileDoesNotExist()
    {
        file_put_contents("$this->tempDir/.env", "FOO=bar\n");
        $_ENV['APP_ENV'] = 'testing';
        $_SERVER['APP_ENV'] = 'testing';
        Env::load($this->tempDir);
        $this->assertEquals('bar', $_ENV['FOO']);
    }

    public function testDetectEnvironmentCli()
    {
        // No APP_ENV, CLI SAPI: should be 'development'
        unset($_ENV['APP_ENV'], $_SERVER['APP_ENV']);
        file_put_contents("$this->tempDir/.env", "");
        Env::load($this->tempDir);
        $this->assertEquals('development', $_ENV['APP_ENV']);
        $this->assertEquals('development', $_SERVER['APP_ENV']);
    }

    public function testDetectEnvironmentServerName()
    {
        unset($_ENV['APP_ENV'], $_SERVER['APP_ENV']);
        $_SERVER['SERVER_NAME'] = 'myapp.localhost';
        file_put_contents("$this->tempDir/.env", "");
        Env::load($this->tempDir);
        $this->assertEquals('development', $_ENV['APP_ENV']);
    }

    public function testGetReturnsDefaultForMissing()
    {
        $this->assertEquals('zzz', Env::get('NOT_SET', 'zzz'));
    }

    public function testIsDev()
    {
        $_ENV['APP_ENV'] = 'development';
        $this->assertTrue(Env::isDev());
        $_ENV['APP_ENV'] = 'production';
        $this->assertFalse(Env::isDev());
    }

    public function testDetectEnvironmentServerNameTriggersDevelopment()
    {
        unset($_ENV['APP_ENV'], $_SERVER['APP_ENV']);
        $_SERVER['SERVER_NAME'] = 'foo.localhost';
        // We must trigger Env::load, which will call detectEnvironment
        file_put_contents("$this->tempDir/.env", "");
        Env::load($this->tempDir);
        $this->assertEquals('development', $_ENV['APP_ENV']);
    }
}
