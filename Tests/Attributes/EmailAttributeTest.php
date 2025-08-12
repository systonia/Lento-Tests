<?php

use PHPUnit\Framework\TestCase;
use Lento\Attributes\Email;

class EmailAttributeTestModel
{
    #[Email]
    public string $email;
}

class EmailAttributeTest extends TestCase
{
    public function testEmailAttributeIsDetected(): void
    {
        $refClass = new \ReflectionClass(EmailAttributeTestModel::class);
        $property = $refClass->getProperty('email');
        $attributes = $property->getAttributes(Email::class);

        $this->assertCount(1, $attributes, 'Expected one Email attribute on the property.');
        $instance = $attributes[0]->newInstance();

        $this->assertInstanceOf(Email::class, $instance);
    }
}
