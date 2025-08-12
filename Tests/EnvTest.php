<?php

namespace Lento\Tests;

use Lento\Env;

class EnvTest extends BaseTestCase
{
    protected string $envFile;
    protected string $envFile_empty;
    protected string $envFile_invalid;

    protected function setUp(): void
    {
        Env::load(__DIR__);
    }

    public function testLoadsEnvFile()
    {
        $this->assertSame('development', Env::get('APP_ENV'));
        $this->assertSame('dev', Env::get('DYNAMIC'));
        $this->assertSame('other', Env::get('OTHER'));
    }
}
