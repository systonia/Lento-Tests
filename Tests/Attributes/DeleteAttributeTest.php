<?php

use PHPUnit\Framework\TestCase;
use Lento\Attributes\Delete;

class DeleteTestController
{
    #[Delete('/users/{id}')]
    public function deleteUser() {}
}

class DeleteAttributeTest extends TestCase
{
    public function testDeleteAttributeParsesPathAndMethod(): void
    {
        $refClass = new \ReflectionClass(DeleteTestController::class);
        $method = $refClass->getMethod('deleteUser');
        $attributes = $method->getAttributes(Delete::class);

        $this->assertCount(1, $attributes);

        $instance = $attributes[0]->newInstance();

        $this->assertInstanceOf(Delete::class, $instance);
        $this->assertSame('DELETE', $instance->getHttpMethod());
        $this->assertSame('/users/{id}', $instance->getPath());
    }
}
