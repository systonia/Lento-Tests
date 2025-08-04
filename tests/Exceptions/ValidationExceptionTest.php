<?php

use PHPUnit\Framework\TestCase;
use Lento\Exceptions\ValidationException;
use Lento\Enums\Message;

final class ValidationExceptionTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $e = new ValidationException();
        $this->assertInstanceOf(ValidationException::class, $e);
        $this->assertEquals(Message::ValidationFailed->value, $e->getMessage());
        $this->assertEquals(422, $e->getCode());
        $this->assertEquals([], $e->getErrors());
    }

    public function testCustomMessageAndErrors()
    {
        $msg = "My validation failed";
        $errors = ['foo' => 'bad', 'bar' => 'missing'];
        $code = 409;
        $e = new ValidationException($msg, $errors, $code);
        $this->assertEquals($msg, $e->getMessage());
        $this->assertEquals($code, $e->getCode());
        $this->assertEquals($errors, $e->getErrors());
    }

    public function testMessageAsEnum()
    {
        $e = new ValidationException(Message::ValidationFailed, [], 422);
        $this->assertEquals(Message::ValidationFailed->value, $e->getMessage());
    }

    public function testWithPrevious()
    {
        $prev = new \Exception("fail");
        $e = new ValidationException("test", [], 422, $prev);
        $this->assertSame($prev, $e->getPrevious());
    }
}
