<?php

use PHPUnit\Framework\TestCase;
use Lento\Attributes\{Controller, Body};


#[Controller('/test')]
class TestController
{
    public function create(#[Body('user')] string $payload): void
    {
    }
}

class BodyAttributeTest extends TestCase
{

    public function testBodyAttributeIsParsedCorrectly(): void
    {
        $refClass = new \ReflectionClass(TestController::class);
        $method = $refClass->getMethod('create');
        $params = $method->getParameters();

        $this->assertCount(1, $params);

        $attributes = $params[0]->getAttributes(Body::class);
        $this->assertCount(1, $attributes);

        $instance = $attributes[0]->newInstance();
        $this->assertInstanceOf(Body::class, $instance);
        $this->assertSame('user', $instance->name);
    }
}
