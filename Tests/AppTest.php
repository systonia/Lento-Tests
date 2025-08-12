<?php

namespace Lento\Tests;

use Lento\{App, OpenAPI};
use Lento\Tests\Fixtures\{CustomersController};

final class AppTest extends BaseTestCase
{
    protected function setUp(): void
    {
        OpenAPI::configure([
            'tags' => [
                ['name' => 'products', 'description' => 'Bakery products'],
                ['name' => 'orders', 'description' => 'Order data'],
                ['name' => 'customers', 'description' => 'Customer data'],
            ]
        ]);

        App::create(controllers: [
            CustomersController::class
        ]);

        App::useCors([]);

        parent::setUp();
    }

    public function testMinimalAppSetup()
    {
        $router = App::getRouter();
        $routes = $router->getRoutes();

        $this->assertNotEmpty($routes);

        $route = $router->findRoute($routes, 'GET', '/customers');
        $this->assertNotNull($route);

        $route = $router->findRoute($routes, 'GET', '/customers/{customerId}/orders');
        $this->assertNotNull($route);

        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWUsImlhdCI6MTUxNjIzOTAyMn0.KMUFsIDTnFmyG3nMiGM6H9FNFUROf3wh7SmqJp-QV30';
        $_SERVER['REQUEST_URI'] = '/customers/1/orders';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        App::run();
        $output = ob_get_clean();

        $this->assertEquals('"1"', $output);
    }
}