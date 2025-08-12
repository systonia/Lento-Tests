<?php

use PHPUnit\Framework\TestCase;

use Lento\{App, OpenAPI, JWT, Env, FileSystem, Renderer};
use Lento\Tests\Fixtures\{CustomersController, OrdersController};

final class FullAppTest extends TestCase
{
    public function testMinimalAppSetup()
    {

        JWT::configure(['secret' => Env::get('JWT_SECRET', 'helloworld!')]);
        FileSystem::setCacheDirectory(__DIR__ . '/cache')
            ::setPublicDirectory(__DIR__ . '/public');
        OpenAPI::configure([
            'tags'=> [
                ['name' => 'products', 'description' => 'Bakery products'],
                ['name' => 'orders', 'description' => 'Order data'],
                ['name' => 'customers', 'description' => 'Customer data'],
            ]
        ]);

        Renderer::configure([
            'directory' => __DIR__ . '/Views',
            'layout' => '_Layout'
        ]);

        App::create(controllers: [
            CustomersController::class,
            OrdersController::class
        ]);


        App::useJWT();

        App::useCors([]);

        $router = App::getRouter();
        $routes = $router->getRoutes();

        $this->assertNotEmpty($routes);

        $route = $router->findRoute($routes, 'GET', '/customers');
        $this->assertNotNull($route);

        $route = $router->findRoute($routes, 'GET', '/customers/{customerId}/orders');
        $this->assertNotNull($route);

        $_SERVER['REQUEST_URI'] = '/openapi/spec.json';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        App::run();
        $output = ob_get_clean();

        $_SERVER['REQUEST_URI'] = '/customers';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        ob_start();
        App::run();
        $output = ob_get_clean();

        $this->assertNotEmpty($output);
    }
}