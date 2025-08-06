<?php

use PHPUnit\Framework\TestCase;
use Lento\Attributes\FileFormatter;

#[FileFormatter('application/pdf', 'report.pdf', true)]
class AnnotatedClass {}

class MethodClass {
    #[FileFormatter('text/plain', 'foo.txt')]
    public function foo() {}
}

class FileFormatterTest extends TestCase
{
    public function testCanInstantiateWithDefaults()
    {
        $attr = new FileFormatter();
        $this->assertNull($attr->mimetype);
        $this->assertNull($attr->filename);
        $this->assertFalse($attr->download);
    }

    public function testCanInstantiateWithValues()
    {
        $attr = new FileFormatter('image/png', 'file.png', true);
        $this->assertSame('image/png', $attr->mimetype);
        $this->assertSame('file.png', $attr->filename);
        $this->assertTrue($attr->download);
    }

    public function testAttributeOnClass()
    {
        $ref = new ReflectionClass(AnnotatedClass::class);
        $attrs = $ref->getAttributes(FileFormatter::class);
        $this->assertCount(1, $attrs);

        $instance = $attrs[0]->newInstance();
        $this->assertSame('application/pdf', $instance->mimetype);
        $this->assertSame('report.pdf', $instance->filename);
        $this->assertTrue($instance->download);
    }

    public function testAttributeOnMethod()
    {
        $refMethod = new ReflectionMethod(MethodClass::class, 'foo');
        $attrsMethod = $refMethod->getAttributes(FileFormatter::class);
        $this->assertCount(1, $attrsMethod);

        $methodInstance = $attrsMethod[0]->newInstance();
        $this->assertSame('text/plain', $methodInstance->mimetype);
        $this->assertSame('foo.txt', $methodInstance->filename);
        $this->assertFalse($methodInstance->download);
    }
}
