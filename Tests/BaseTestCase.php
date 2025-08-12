<?php

namespace Lento\Tests;

use PHPUnit\Framework\TestCase;
use Lento\{Env, Logger};

/**
 * This is a base test case and should not be run directly.
 */
abstract class BaseTestCase extends TestCase
{
    protected function tearDown(): void
    {
        Env::clear();
        Logger::clear();
        parent::tearDown();
    }
}
