<?php

namespace ZfrShopifyTest\Iterator;

use Guzzle\Service\Command\CommandInterface;
use ZfrShopify\Iterator\ShopifyResourceIterator;

/**
 * @author Daniel Gimenes
 */
final class ShopifyResourceIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testInitializesWithMaxPageSize()
    {
        $command          = $this->prophesize(CommandInterface::class);
        $resourceIterator = new ShopifyResourceIterator($command->reveal(), []);

        $this->assertAttributeEquals(250, 'pageSize', $resourceIterator);
    }
}
