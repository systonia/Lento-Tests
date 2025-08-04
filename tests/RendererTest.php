<?php

use PHPUnit\Framework\TestCase;
use Lento\Renderer;
use Lento\RendererOptions;

final class RendererTest extends TestCase
{
    private string $originalScriptFilename;

    protected function setUp(): void
    {
        // Backup the original SCRIPT_FILENAME
        $this->originalScriptFilename = $_SERVER['SCRIPT_FILENAME'] ?? null;
        // Set SCRIPT_FILENAME to the current file for predictable dirname
        $_SERVER['SCRIPT_FILENAME'] = __FILE__;
    }

    protected function tearDown(): void
    {
        // Restore original SCRIPT_FILENAME
        if ($this->originalScriptFilename !== null) {
            $_SERVER['SCRIPT_FILENAME'] = $this->originalScriptFilename;
        } else {
            unset($_SERVER['SCRIPT_FILENAME']);
        }
        Renderer::$options = null;
    }

    public function testRendererOptionsFromArray()
    {
        $opts = new RendererOptions([
            'directory' => 'templates',
            'layout' => 'MyLayout',
        ]);
        $this->assertSame('templates', $opts->directory);
        $this->assertSame('MyLayout', $opts->layout);
    }

    public function testRendererOptionsToArray()
    {
        $opts = new RendererOptions(['directory' => 'views']);
        $arr = $opts->toArray();
        $this->assertArrayHasKey('directory', $arr);
        $this->assertEquals('views', $arr['directory']);
        $this->assertArrayHasKey('layout', $arr);
        $this->assertEquals('_Layout', $arr['layout']);
    }

    public function testRendererConfigureWithOptionsInstance()
    {
        $opts = new RendererOptions(['directory' => 'tpl']);
        Renderer::configure($opts);

        $expectedDir = dirname(realpath(__FILE__)) . '/tpl';
        $this->assertInstanceOf(RendererOptions::class, Renderer::$options);
        $this->assertEquals($expectedDir, Renderer::$options->directory);
    }

    public function testRendererConfigureWithArray()
    {
        Renderer::configure(['directory' => 'abc', 'layout' => 'custom']);
        $expectedDir = dirname(realpath(__FILE__)) . '/abc';
        $this->assertInstanceOf(RendererOptions::class, Renderer::$options);
        $this->assertEquals($expectedDir, Renderer::$options->directory);
        $this->assertEquals('custom', Renderer::$options->layout);
    }
}
