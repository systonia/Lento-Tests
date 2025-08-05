<?php

use PHPUnit\Framework\TestCase;

use Lento\{App, OpenAPI};
use Lento\Attributes\{Get, Summary, Tags, Controller, Param};

#[Controller('/customers')]
class CustomersController
{
    #[Get]
    #[Summary('List customers')]
    #[Tags(['customers'])]
    public function get(): ?string
    {
        return "pong";
    }


    #[Get('/{customerId}/orders')]
    #[Summary('List customer orders')]
    #[Tags(['orders', 'customers'])]
    public function getOrdersByCustomerId(#[Param] string $customerId): string
    {
        return $customerId;
    }
}


final class AppTest extends TestCase
{
    public function testMinimalAppSetup()
    {
        OpenAPI::configure([]);
        OpenAPI::enable()
            ::addTags([
                ['products', 'Bakery products'],
                ['orders', 'Manage orders'],
                ['customers', 'Manage customers'],
            ]);

        App::create(controllers: [CustomersController::class]);

        App::useCors([]);

        $router = App::getRouter();
        $routes = $router->getRoutes();

        $this->assertNotEmpty($routes);

        $this->assertEquals('/customers', $routes[0]->rawPath);
        $this->assertEquals('GET', $routes[0]->method);

        $this->assertEquals('/customers/{customerId}/orders', $routes[1]->rawPath);
        $this->assertEquals('GET', $routes[1]->method);

        $_SERVER['REQUEST_URI'] = '/customers';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        App::run();
        $output = ob_get_clean();

        $this->assertEquals('"pong"', $output);
    }
}