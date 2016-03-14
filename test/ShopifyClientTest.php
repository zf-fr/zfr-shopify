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

namespace ZfrShopifyTest;

use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Service\Command\CommandInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZfrShopify\Exception\InvalidRequestException;
use ZfrShopify\ShopifyClient;

/**
 * @author Michaël Gallego
 */
class ShopifyClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShopifyClient
     */
    private $client;

    public function setUp()
    {
        $this->client = new ShopifyClient([
            'shop'          => 'my_shop',
            'api_key'       => 'abc',
            'access_token'  => 'token',
            'private_app'   => false
        ]);
    }

    public function testCanAuthorizeRequestForPrivateApp()
    {
        $client = new ShopifyClient([
            'shop'        => 'my_shop',
            'api_key'     => 'abc',
            'password'    => 'secret',
            'private_app' => true
        ]);

        $request = $this->prophesize(RequestInterface::class);

        $command = $this->prophesize(CommandInterface::class);
        $command->getRequest()->shouldBeCalled()->willReturn($request->reveal());

        $event = new Event([
            'command' => $command->reveal()
        ]);

        $request->setHeader()->shouldNotBeCalled();
        $request->setAuth('abc', 'secret')->shouldBeCalled();

        $client->authorizeRequest($event);
    }

    public function testCanAuthorizeRequestForPublicApp()
    {
        $client = new ShopifyClient([
            'shop'         => 'my_shop',
            'api_key'      => 'abc',
            'access_token' => 'secret',
            'private_app'  => false
        ]);

        $request = $this->prophesize(RequestInterface::class);

        $command = $this->prophesize(CommandInterface::class);
        $command->getRequest()->shouldBeCalled()->willReturn($request->reveal());

        $event = new Event([
            'command' => $command->reveal()
        ]);

        $request->setAuth()->shouldNotBeCalled();
        $request->setHeader('X-Shopify-Access-Token', 'secret')->shouldBeCalled();

        $client->authorizeRequest($event);
    }

    public function testCanClone()
    {
        $client             = new ShopifyClient([]);
        $originalDispatcher = $client->getEventDispatcher();

        $clonedClient     = clone $client;
        $clonedDispatcher = $clonedClient->getEventDispatcher();

        $this->assertNotSame($originalDispatcher, $clonedDispatcher);
    }
}
