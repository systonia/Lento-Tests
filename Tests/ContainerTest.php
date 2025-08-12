<?php

use PHPUnit\Framework\TestCase;
use Lento\Container;
use Lento\Exceptions\{ContainerException, NotFoundException};

use Lento\Tests\Fixtures\Services\{AnotherService, CrashingService, ExampleService};

final class ContainerTest extends TestCase
{
    public function testSetAndGetReturnsSameInstance()
    {
        $container = new Container();
        $service = new ExampleService();
        $container->set($service);

        $retrieved = $container->get(ExampleService::class);

        $this->assertSame($service, $retrieved, 'Service instance should be the same after set and get');
    }

    public function testHasAfterSet()
    {
        $container = new Container();
        $service = new ExampleService();
        $container->set($service);

        $this->assertTrue($container->has(ExampleService::class), 'Container should report service exists after set');
    }

    public function testHasReturnsTrueForInstantiableClass()
    {
        $container = new Container();
        // Class exists but not set explicitly, should still return true due to auto-instantiation
        $this->assertTrue($container->has(AnotherService::class), 'Container should return true for instantiable class, even if not registered');
    }

    public function testHasReturnsFalseForNonexistentClass()
    {
        $container = new Container();
        // Class doesn't exist anywhere, should return false
        $this->assertFalse($container->has('TotallyFakeClass'), 'Container should return false for class that does not exist');
    }

    public function testGetThrowsNotFoundExceptionForMissingClass()
    {
        $container = new Container();

        $this->expectException(NotFoundException::class);
        $container->get('ThisClassDoesNotExist');
    }

    public function testGetThrowsContainerExceptionIfInstantiationCrashes()
    {
        $container = new Container();
        $this->expectException(ContainerException::class);
        $container->get(CrashingService::class);
    }
}
