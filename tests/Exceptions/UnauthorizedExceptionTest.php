<?php

use PHPUnit\Framework\TestCase;
use Lento\Exceptions\UnauthorizedException;
use Lento\Enums\Message;

final class UnauthorizedExceptionTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $e = new UnauthorizedException();
        $this->assertInstanceOf(UnauthorizedException::class, $e);
        $this->assertEquals(Message::Unauthorized->value, $e->getMessage());
        $this->assertEquals(401, $e->getCode());
    }

    public function testCustomMessageAndCode()
    {
        $msg = "Custom unauthorized";
        $code = 499;
        $e = new UnauthorizedException($msg, $code);
        $this->assertEquals($msg, $e->getMessage());
        $this->assertEquals($code, $e->getCode());
    }

    public function testWithPrevious()
    {
        $prev = new \Exception("previous");
        $e = new UnauthorizedException("fail", 401, $prev);
        $this->assertSame($prev, $e->getPrevious());
    }
}
