<?php

use Lento\Enums\Message;
use PHPUnit\Framework\TestCase;

class MessageEnumTest extends TestCase
{
    public function testFormatReplacesVariables()
    {
        $msg = Message::GeneratorPropertyDoesNotExist;
        $vars = [
            'property' => 'type',
            'name' => 'foo',
            'rc' => 'BarClass',
        ];
        $expected = 'OpenAPIGenerator: Property type "type" does not exist (property "foo" in class "BarClass")';
        $this->assertEquals($expected, $msg->format($vars));
    }

    public function testFormatWithMissingVars()
    {
        $msg = Message::GeneratorPropertyDoesNotExist;
        // Only provide some variables
        $vars = [
            'property' => 'id',
            // name is missing
            'rc' => 'TestClass',
        ];
        // {name} should remain unreplaced
        $expected = 'OpenAPIGenerator: Property type "id" does not exist (property "{name}" in class "TestClass")';
        $this->assertEquals($expected, $msg->format($vars));
    }

    public function testFormatWithNoVars()
    {
        $msg = Message::Forbidden;
        $this->assertEquals('Forbidden', $msg->format());
    }

    public function testInterpolateNamedParams()
    {
        $msg = Message::GeneratorClassDoesNotExist;
        $result = $msg->interpolate(fqcn: 'Foo\\Bar');
        $this->assertEquals(
            'OpenAPIGenerator: generateModelSchema - class "Foo\\Bar" does not exist.',
            $result
        );
    }

    public function testInterpolateWithExtraParams()
    {
        $msg = Message::GeneratorClassDoesNotExist;
        // Extra params are ignored
        $result = $msg->interpolate(fqcn: 'ClassA', extra: 'ignored');
        $this->assertEquals(
            'OpenAPIGenerator: generateModelSchema - class "ClassA" does not exist.',
            $result
        );
    }

    public function testEnumValue()
    {
        $this->assertEquals('Not Found', Message::NotFound->value);
    }
}
