<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

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
