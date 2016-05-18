<?php

namespace ZfrShopifyTest\Iterator;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Description\OperationInterface;
use ZfrShopify\Exception\InvalidArgumentException;
use ZfrShopify\Iterator\ShopifyResourceIterator;
use ZfrShopify\Iterator\ShopifyResourceIteratorFactory;

/**
 * @author Daniel Gimenes
 */
final class ShopifyResourceIteratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsExceptionIfCommandIsNotTraversable()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ShopifyResourceIteratorFactory())->build(new OperationCommand());
    }

    public function testBuildsIteratorForTraversableCommands()
    {
        $command   = $this->prophesize(OperationCommand::class);
        $operation = $this->prophesize(OperationInterface::class);

        $command->getOperation()->shouldBeCalled()->willReturn($operation->reveal());
        $operation->hasParam('since_id')->shouldBeCalled()->willReturn(true);

        $resourceIterator = (new ShopifyResourceIteratorFactory())->build($command->reveal());

        $this->assertInstanceOf(ShopifyResourceIterator::class, $resourceIterator);
    }
}
