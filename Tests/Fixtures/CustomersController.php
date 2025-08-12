<?php

namespace Lento\Tests\Fixtures;

use Lento\Http\{Request, View};
use Lento\Attributes\{Controller, Get, Summary, Tags, Param};

#[Controller('/customers')]
class CustomersController
{
    #[Get]
    public function index(Request $request): View
    {

        return new View('HomePage', null, partial:$request->acceptPartial);
    }


    #[Get('/{customerId}/orders')]
    #[Summary('List customer orders')]
    #[Tags(['orders', 'customers'])]
    public function getOrdersByCustomerId(#[Param] string $customerId): string
    {
        return $customerId;
    }
}