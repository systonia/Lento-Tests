<?php

namespace Lento\Tests\Fixtures;

use Lento\Attributes\{Controller, Get, Summary, Tags, Post};

#[Controller('/orders')]
#[Tags(['orders'])]
class OrdersController
{
    #[Post]
    #[Summary('Place an order')]
    public function placeOrder(): ?string
    {
        return "pong";
    }

    #[Get('/{orderId}')]
    #[Summary('Get order details')]
    public function ping(): ?string
    {
        return "pong";
    }
}