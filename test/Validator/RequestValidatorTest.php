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

namespace ZfrShopifyTest\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use ZfrShopify\Exception\InvalidRequestException;
use ZfrShopify\Validator\RequestValidator;

/**
 * @author Michaël Gallego
 */
class RequestValidatorTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function shopHmacProvider()
    {
        $key       = 'shop=mystore.myshopify.com&timestamp=123';
        $validHmac = hash_hmac('sha256', $key, 'secret');

        return [
            ['Everything is okay'       => 'mystore.myshopify.com', 123, $validHmac, 'secret', true],
            ['Secret was not same'      => 'mystore.myshopify.com', 123, $validHmac, 'another_secret', false],
            ['Timestamp does not match' => 'mystore.myshopify.com', 1234, $validHmac, 'secret', false],
            ['Hmac is wrong'            => 'mystore.myshopify.com', 123, $validHmac . '_foo', 'secret', false],
            ['Shop does not match'      => 'my_store.myshopify.com', 1234, $validHmac, 'secret', false],
        ];
    }

    /**
     * @dataProvider shopHmacProvider
     */
    public function testValidateHmac($shop, $timestamp, $hmac, $secret, $isValid)
    {
        $request   = $this->prophesize(ServerRequestInterface::class);
        $validator = new RequestValidator();

        if (!$isValid) {
            $this->expectException(InvalidRequestException::class);
        }

        // We try in different order to make sure it does not change anything as the signature must be insensitive

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'shop'      => $shop,
            'timestamp' => $timestamp,
            'hmac'      => $hmac
        ]);
        $validator->validateRequest($request->reveal(), $secret);

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'timestamp' => $timestamp,
            'shop'      => $shop,
            'hmac'      => $hmac
        ]);
        $validator->validateRequest($request->reveal(), $secret);

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'hmac'      => $hmac,
            'shop'      => $shop,
            'timestamp' => $timestamp
        ]);
        $validator->validateRequest($request->reveal(), $secret);

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'timestamp' => $timestamp,
            'hmac'      => $hmac,
            'shop'      => $shop
        ]);
        $validator->validateRequest($request->reveal(), $secret);
    }
}
