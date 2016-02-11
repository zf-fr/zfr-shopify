<?php

namespace ZfrShopifyTest\Model;

use ZfrShopify\Exception\InvalidArgumentException;
use ZfrShopify\Model\ShopDomain;

class ShopDomainTest extends \PHPUnit_Framework_TestCase
{
    public function domainProvider()
    {
        return [
            [
                'domain' => 'test',
                'valid'  => false
            ],
            [
                'domain' => 'test@@.myshopify.com',
                'valid'  => false
            ],
            [
                'domain' => 'test.myshopify.com/other',
                'valid'  => false
            ],
            [
                'domain' => 'test.myshopify.com',
                'valid'  => true
            ]
        ];
    }

    /**
     * @dataProvider domainProvider
     */
    public function testShopDomain(string $domain, bool $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        }

        new ShopDomain($domain);
    }
}