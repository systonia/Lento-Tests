<?php

use PHPUnit\Framework\TestCase;
use Lento\Exceptions\ForbiddenException;
use Lento\Enums\Message;

final class ForbiddenExceptionTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $e = new ForbiddenException();
        $this->assertInstanceOf(ForbiddenException::class, $e);
        $this->assertEquals(Message::Forbidden->value, $e->getMessage());
        $this->assertEquals(403, $e->getCode());
    }

    public function testCustomMessageAndCode()
    {
        $msg = "Custom forbidden";
        $code = 402;
        $e = new ForbiddenException($msg, $code);
        $this->assertEquals($msg, $e->getMessage());
        $this->assertEquals($code, $e->getCode());
    }

    public function testWithPrevious()
    {
        $prev = new \Exception("Prev message");
        $e = new ForbiddenException("fail", 403, $prev);
        $this->assertSame($prev, $e->getPrevious());
    }
}
