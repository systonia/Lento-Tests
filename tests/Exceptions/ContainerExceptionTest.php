<?php

use PHPUnit\Framework\TestCase;
use Lento\Exceptions\ContainerException;
use Psr\Container\ContainerExceptionInterface;

final class ContainerExceptionTest extends TestCase
{
    public function testInstantiate()
    {
        $e = new ContainerException("fail", 123);
        $this->assertInstanceOf(ContainerException::class, $e);
        $this->assertInstanceOf(ContainerExceptionInterface::class, $e);
        $this->assertEquals("fail", $e->getMessage());
        $this->assertEquals(123, $e->getCode());
    }
}
