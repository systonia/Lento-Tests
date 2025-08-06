<?php

use PHPUnit\Framework\TestCase;
use Lento\Attributes\Controller;

#[Controller('/api')]
class ControllerTestController
{
}

#[Controller]
class DefaultPathController
{
}

class ControllerAttributeTest extends TestCase
{
    public function testControllerAttributeParsesPathCorrectly(): void
    {
        $refClass = new \ReflectionClass(ControllerTestController::class);
        $attributes = $refClass->getAttributes(Controller::class);

        $this->assertCount(1, $attributes);

        $instance = $attributes[0]->newInstance();
        $this->assertInstanceOf(Controller::class, $instance);
        $this->assertSame('/api', $instance->getPath());
    }

    public function testControllerAttributeDefaultsToEmptyPath(): void
    {

        $refClass = new \ReflectionClass(DefaultPathController::class);
        $attributes = $refClass->getAttributes(Controller::class);
        $instance = $attributes[0]->newInstance();

        $this->assertSame('', $instance->getPath());
    }
}
