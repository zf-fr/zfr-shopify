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

use GuzzleHttp\Command\CommandInterface;
use GuzzleHttp\Command\Guzzle\DescriptionInterface;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Operation;
use GuzzleHttp\Command\ServiceClientInterface;
use GuzzleHttp\Command\ToArrayInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZfrShopify\Exception\RuntimeException;
use ZfrShopify\ShopifyClient;

/**
 * @author Michaël Gallego
 */
class ShopifyClientTest extends \PHPUnit_Framework_TestCase
{
    public function validationData()
    {
        return [
            [
                [],
                false
            ],
            [
                [
                    'shop'        => 'test.myshopify.com',
                    'api_key'     => 'key_123',
                    'private_app' => true
                ],
                false
            ],
            [
                [
                    'shop'        => 'test.myshopify.com',
                    'api_key'     => 'key_123',
                    'private_app' => false
                ],
                false
            ],
            [
                [
                    'shop'        => 'test.myshopify.com',
                    'api_key'     => 'key_123',
                    'private_app' => true,
                    'password'    => 'pass_123'
                ],
                true
            ],
            [
                [
                    'shop'         => 'test.myshopify.com',
                    'api_key'      => 'key_123',
                    'private_app'  => false,
                    'access_token' => 'token_123'
                ],
                true
            ]
        ];
    }

    /**
     * @dataProvider validationData
     */
    public function testValidation(array $data, bool $isValid)
    {
        if (!$isValid) {
            $this->expectException(RuntimeException::class);
        }

        new ShopifyClient($data);
    }

    public function testStopRetryingAfterFiveAttempts()
    {
        $client = $this->getShopifyClientForPublicApp();

        $this->assertFalse($client->retryDecider(6, $this->prophesize(RequestInterface::class)->reveal()));
    }

    public function testRetryOnConnectionException()
    {
        $client = $this->getShopifyClientForPublicApp();

        $request   = $this->prophesize(RequestInterface::class)->reveal();
        $response  = $this->prophesize(ResponseInterface::class)->reveal();
        $exception = $this->prophesize(ConnectException::class)->reveal();

        $this->assertTrue($client->retryDecider(4, $request, $response, $exception));
    }

    public function statusCodeProvider()
    {
        return [
           [400],
           [404],
           [429],
           [500]
        ];
    }

    /**
     * @dataProvider statusCodeProvider
     */
    public function testRetryOnTooManyRequestsStatusCode(int $statusCode)
    {
        $client = $this->getShopifyClientForPublicApp();

        $request  = $this->prophesize(RequestInterface::class)->reveal();
        $response = $this->prophesize(ResponseInterface::class);
        $response->getStatusCode()->shouldBeCalled()->willReturn($statusCode);
        $exception = $this->prophesize(RequestException::class)->reveal();

        if ($statusCode === 429) {
            $this->assertTrue($client->retryDecider(4, $request, $response->reveal(), $exception));
        } else {
            $this->assertFalse($client->retryDecider(4, $request, $response->reveal(), $exception));
        }
    }

    public function testRetryDelay()
    {
        $client = $this->getShopifyClientForPublicApp();

        $this->assertEquals(1000, $client->retryDelay(1));
        $this->assertEquals(2000, $client->retryDelay(2));
    }

    public function testCanDoCallForPublicApp()
    {
        $serviceClient = $this->prophesize(GuzzleClient::class);
        $client        = $this->getShopifyClientForPublicApp($serviceClient->reveal());

        $expectedArgs = [
            'fields' => 'id,name',
            '@http'  => [
                'headers' => [
                    'X-Shopify-Access-Token' => 'token_123'
                ]
            ]
        ];

        $command = $this->prophesize(CommandInterface::class);
        $command->getName()->shouldBeCalled()->willReturn('GetShop');

        $result = $this->prophesize(ToArrayInterface::class);
        $result->toArray()->shouldBeCalled()->willReturn(['shop' => ['id' => 123, 'name' => 'Test shop']]);

        $serviceClient->getCommand('GetShop', $expectedArgs)->shouldBeCalled()->willReturn($command->reveal());
        $serviceClient->execute($command)->shouldBeCalled()->willReturn($result->reveal());

        $description = $this->prophesize(DescriptionInterface::class);
        $serviceClient->getDescription()->shouldBeCalled()->willReturn($description->reveal());

        $operation = $this->prophesize(Operation::class);
        $description->getOperation('GetShop')->shouldBeCalled()->willReturn($operation->reveal());

        $operation->getData('root_key')->shouldBeCalled()->willReturn('shop');

        $payload = $client->getShop(['fields' => 'id,name']);

        $this->assertEquals(['id' => 123, 'name' => 'Test shop'], $payload);
    }

    public function testCanDoCallForPrivateApp()
    {
        $serviceClient = $this->prophesize(GuzzleClient::class);
        $client        = $this->getShopifyClientForPrivateApp($serviceClient->reveal());

        $expectedArgs = [
            'fields' => 'id,name',
            '@http'  => [
                'auth' => ['key', 'password_123']
            ]
        ];

        $command = $this->prophesize(CommandInterface::class);
        $command->getName()->shouldBeCalled()->willReturn('GetShop');

        $result = $this->prophesize(ToArrayInterface::class);
        $result->toArray()->shouldBeCalled()->willReturn(['shop' => ['id' => 123, 'name' => 'Test shop']]);

        $serviceClient->getCommand('GetShop', $expectedArgs)->shouldBeCalled()->willReturn($command->reveal());
        $serviceClient->execute($command)->shouldBeCalled()->willReturn($result->reveal());

        $description = $this->prophesize(DescriptionInterface::class);
        $serviceClient->getDescription()->shouldBeCalled()->willReturn($description->reveal());

        $operation = $this->prophesize(Operation::class);
        $description->getOperation('GetShop')->shouldBeCalled()->willReturn($operation->reveal());

        $operation->getData('root_key')->shouldBeCalled()->willReturn('shop');

        $payload = $client->getShop(['fields' => 'id,name']);

        $this->assertEquals(['id' => 123, 'name' => 'Test shop'], $payload);
    }

    private function getShopifyClientForPublicApp(ServiceClientInterface $client = null): ShopifyClient
    {
        $options = [
            'shop'         => 'test.myshopify.com',
            'private_app'  => false,
            'access_token' => 'token_123',
            'api_key'      => 'key'
        ];

        return new ShopifyClient($options, $client);
    }

    private function getShopifyClientForPrivateApp(ServiceClientInterface $client = null): ShopifyClient
    {
        $options = [
            'shop'         => 'test.myshopify.com',
            'private_app'  => true,
            'password'     => 'password_123',
            'api_key'      => 'key'
        ];

        return new ShopifyClient($options, $client);
    }
}
