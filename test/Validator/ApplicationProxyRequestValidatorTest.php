<?php

namespace ZfrShopifyTest\Validator;

use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\ServerRequestInterface;
use ZfrShopify\Exception\InvalidApplicationProxyRequestException;
use ZfrShopify\Validator\ApplicationProxyRequestValidator;

class ApplicationProxyRequestValidatorTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testValidateSignature()
    {
        $sharedSecret = 'hush';
        $request      = $this->prophesize(ServerRequestInterface::class);
        $validator    = new ApplicationProxyRequestValidator();

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'extra'       => [1, 2],
            'shop'        => 'shop-name.myshopify.com',
            'path_prefix' => '/apps/awesome_reviews',
            'timestamp'   => '1317327555',
            'signature'   => 'a9718877bea71c2484f91608a7eaea1532bdf71f5c56825065fa4ccabe549ef3'
        ]);

        $validator->validateRequest($request->reveal(), $sharedSecret);
    }

    public function testValidateSignatureWithReorderedParams()
    {
        $sharedSecret = 'hush';
        $request      = $this->prophesize(ServerRequestInterface::class);
        $validator    = new ApplicationProxyRequestValidator();

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'timestamp'   => '1317327555',
            'shop'        => 'shop-name.myshopify.com',
            'path_prefix' => '/apps/awesome_reviews',
            'signature'   => 'a9718877bea71c2484f91608a7eaea1532bdf71f5c56825065fa4ccabe549ef3',
            'extra'       => [1, 2]
        ]);

        $validator->validateRequest($request->reveal(), $sharedSecret);
    }

    public function testRejectInvalidSignature()
    {
        $this->expectException(InvalidApplicationProxyRequestException::class);

        $sharedSecret = 'hush';
        $request      = $this->prophesize(ServerRequestInterface::class);
        $validator    = new ApplicationProxyRequestValidator();

        $request->getQueryParams()->shouldBeCalled()->willReturn([
            'extra'       => [1, 2],
            'shop'        => 'shop-name.myshopify.com',
            'path_prefix' => '/apps/awesome_reviews',
            'timestamp'   => '1317327555',
            'signature'   => 'INVALID'
        ]);

        $validator->validateRequest($request->reveal(), $sharedSecret);
    }
}
