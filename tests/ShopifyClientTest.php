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
use ZfrShopify\Exception\MissingSignatureException;
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
            'shared_secret' => 'secret',
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

        $request = $this->getMock(RequestInterface::class);

        $command = $this->getMock(CommandInterface::class);
        $command->expects($this->once())->method('getRequest')->willReturn($request);

        $event = new Event([
            'command' => $command
        ]);

        $request->expects($this->never())->method('setHeader');
        $request->expects($this->once())->method('setAuth')->with('abc', 'secret');

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

        $request = $this->getMock(RequestInterface::class);

        $command = $this->getMock(CommandInterface::class);
        $command->expects($this->once())->method('getRequest')->willReturn($request);

        $event = new Event([
            'command' => $command
        ]);

        $request->expects($this->never())->method('setAuth');
        $request->expects($this->once())->method('setHeader')->with('X-Shopify-Access-Token', 'secret');

        $client->authorizeRequest($event);
    }

    public function incomingRequestMissingProvider()
    {
        return [
            [null, null, null],
            [null, null, 1234],
            [null, 'hmac', 1234],
            ['my_shop', 'hmac', null],
            ['my_shop', null, null],
            [null, 'hmac', null]
        ];
    }

    /**
     * @dataProvider incomingRequestMissingProvider
     */
    public function testThrowExceptionWhenAuthenticationIsMissing($shop, $hmac, $timestamp)
    {
        $this->setExpectedException(MissingSignatureException::class);

        $queryParams = [
            'shop'      => $shop,
            'hmac'      => $hmac,
            'timestamp' => $timestamp
        ];

        $request = $this->getMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getQueryParams')->willReturn($queryParams);

        $this->client->validateRequest($request);
    }

    public function shopHostnameProvider()
    {
        return [
            ['mystore.myshopify.com', true],
            ['my-store.myshopify.com', true],
            ['my-store45.myshopify.com', true],
            ['mystore.myshopify.net', false],
            ['mystore.ourshopify.com', false],
            ['my_store.myshopify.net', false],
        ];
    }

    /**
     * @dataProvider shopHostnameProvider
     */
    public function testValidateShopHostname($shop, $isValid)
    {
        $reflMethod = new \ReflectionMethod($this->client, 'validateShopHostname');
        $reflMethod->setAccessible(true);

        if (!$isValid) {
            $this->setExpectedException(InvalidRequestException::class);
        }

        $reflMethod->invoke($this->client, $shop);
    }

    public function shopHmacProvider()
    {
        $key       = strtr('shop=mystore.myshopify.com&timestamp=123', ['&' => '%26', '%' => '%25', '=' => '%3D']);
        $validHmac = hash_hmac('sha256', $key, 'secret');

        return [
            ['Everything is okay'       => 'mystore.myshopify.com', 123, $validHmac, 'secret', true],
            ['Secret was not same'      => 'mystore.myshopify.com', 123, $validHmac, 'another_secret', false],
            ['Timestamp does not match' => 'mystore.myshopify.com', 1234, $validHmac, 'secret', false],
            ['Store does not match'     => 'my_store.myshopify.com', 1234, $validHmac, 'secret', false],
        ];
    }

    /**
     * @dataProvider shopHmacProvider
     */
    public function testValidateHmac($shop, $timestamp, $hmac, $secret, $isValid)
    {
        $client = new ShopifyClient([
            'shared_secret' => $secret,
        ]);

        $reflMethod = new \ReflectionMethod($client, 'validateHmac');
        $reflMethod->setAccessible(true);

        if (!$isValid) {
            $this->setExpectedException(InvalidRequestException::class);
        }

        $reflMethod->invoke($client, $shop, $timestamp, $hmac);
    }

    public function testThrowExceptionIfWebhookHeaderIsNotPresent()
    {
        $this->setExpectedException(InvalidRequestException::class);

        $request = $this->getMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getHeaderLine')->with('X-Shopify-Hmac-SHA256')->willReturn('');

        $this->client->validateWebhook($request);
    }

    public function testCanCreateAuthorizationReponse()
    {
        $response = $this->client->createAuthorizationResponse('mystore', ['read_content', 'write_content'], 'https://www.mysite.com');
        $location = $response->getHeaderLine('Location');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertContains('https://mystore.myshopify.com/admin/oauth/authorize', $location);
        $this->assertContains('client_id=abc', $location);
        $this->assertContains('scope=read_content,write_content', $location);
        $this->assertContains('redirect_uri=https://www.mysite.com', $location);
        $this->assertContains('state=', $location);
    }
}