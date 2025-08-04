<?php

use PHPUnit\Framework\TestCase;
use Lento\Exceptions\NotFoundException;
use Psr\Container\NotFoundExceptionInterface;
use Lento\Enums\Message;

final class NotFoundExceptionTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $e = new NotFoundException();
        $this->assertInstanceOf(NotFoundException::class, $e);
        $this->assertInstanceOf(NotFoundExceptionInterface::class, $e);
        $this->assertEquals(Message::NotFound->value, $e->getMessage());
        $this->assertEquals(404, $e->getCode());
    }

    public function testCustomMessageAndCode()
    {
        $msg = "This is custom";
        $code = 418;
        $e = new NotFoundException($msg, $code);
        $this->assertEquals($msg, $e->getMessage());
        $this->assertEquals($code, $e->getCode());
    }

    public function testWithPrevious()
    {
        $prev = new \Exception("prev");
        $e = new NotFoundException("fail", 404, $prev);
        $this->assertSame($prev, $e->getPrevious());
    }
}
