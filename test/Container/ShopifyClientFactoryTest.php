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

namespace ZfrShopifyTest\Container;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;
use ZfrShopify\Exception\RuntimeException;
use ZfrShopify\Container\ShopifyClientFactory;

/**
 * @author Michaël Gallego
 */
class ShopifyClientFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testThrowExceptionIfNoConfig()
    {
        $this->expectException(RuntimeException::class);

        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->shouldBeCalled()->willReturn(true);
        $container->get('config')->shouldBeCalled()->willReturn([]);

        $factory = new ShopifyClientFactory();
        $factory->__invoke($container->reveal());
    }

    public function testCanCreateService()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->shouldBeCalled()->willReturn(true);
        $container->get('config')->shouldBeCalled()->willReturn([
            'zfr_shopify' => [
                'shop'          => 'example.myshopify.com',
                'version'       => '2019-04',
                'api_key'       => 'key',
                'access_token'  => 'token',
                'private_app'   => false
            ]
        ]);

        $factory = new ShopifyClientFactory();
        $factory->__invoke($container->reveal());
    }
}
