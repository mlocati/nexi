<?php

declare(strict_types=1);

namespace MLocati\Nexi\XPayWeb\Test\Cases;

use MLocati\Nexi\XPayWeb\Entity\CreateOrderForHostedPayment\Request;
use MLocati\Nexi\XPayWeb\Entity\Order;
use PHPUnit\Framework\TestCase;

class GetOrCreateTest extends TestCase
{
    public function testGetOrCreate(): void
    {
        $request = new Request();
        $this->assertNull($request->getOrder());
        $order = $request->getOrCreateOrder();
        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame($order, $request->getOrder());
        $this->assertSame($order, $request->getOrCreateOrder());
    }
}
