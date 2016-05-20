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

namespace ZfrShopifyTest\OAuth;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use ZfrShopify\Exception\RuntimeException;
use ZfrShopify\OAuth\TokenExchanger;

/**
 * @author Michaël Gallego
 */
class TokenExchangerTest extends \PHPUnit_Framework_TestCase
{
    public function shopDomainProvider()
    {
        return [
            ['test.myshopify.com/'],
            ['test.myshopify.com']
        ];
    }

    /**
     * @dataProvider shopDomainProvider
     */
    public function testExchangesCodeForToken()
    {
        $client         = $this->prophesize(ClientInterface::class);
        $tokenExchanger = new TokenExchanger($client->reveal());

        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->shouldBeCalled()->willReturn(
            '{"access_token": "tok_123", "scope": "write_orders,read_customers"}'
        );

        $url = 'https://test.myshopify.com/admin/oauth/access_token';

        $client->request('POST', $url, [
            'json' => [
                'client_id'     => 'app_123',
                'client_secret' => 'secret',
                'code'          => 'code_123'
            ]
        ])->shouldBeCalled()->willReturn($response->reveal());

        $code = $tokenExchanger->exchangeCodeForToken(
            'app_123',
            'secret',
            'test.myshopify.com',
            ['write_orders', 'read_customers'],
            'code_123'
        );

        $this->assertEquals('tok_123', $code);
    }

    public function testThrowsExceptionIfMissingScopes()
    {
        $client         = $this->prophesize(ClientInterface::class);
        $tokenExchanger = new TokenExchanger($client->reveal());

        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()->shouldBeCalled()->willReturn(
            '{"access_token": "tok_123", "scope": "write_orders,read_orders"}'
        );

        $url = 'https://test.myshopify.com/admin/oauth/access_token';

        $client->request('POST', $url, [
            'json' => [
                'client_id'     => 'app_123',
                'client_secret' => 'secret',
                'code'          => 'code_123'
            ]
        ])->shouldBeCalled()->willReturn($response->reveal());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Missing authorization for: "write_products, read_products"');

        $tokenExchanger->exchangeCodeForToken(
            'app_123',
            'secret',
            'test.myshopify.com',
            ['write_orders', 'read_orders', 'write_products', 'read_products'],
            'code_123'
        );
    }
}
