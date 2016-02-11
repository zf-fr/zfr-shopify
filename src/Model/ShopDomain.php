<?php

namespace ZfrShopify\Model;

use ZfrShopify\Exception;

/**
 * Simple value object that can be re-used whenever you need to interact with a shop domain, by making sure the shop domain
 * is valid
 *
 * @author Michaël Gallego
 */
class ShopDomain
{
    /**
     * @var string
     */
    private $shopDomain;

    /**
     * @param string $shopDomain
     */
    public function __construct(string $shopDomain)
    {
        if (!preg_match('/^[a-zA-Z0-9.-]*(myshopify.com)$/', $shopDomain)) {
            throw new Exception\InvalidArgumentException('Shop domain is invalid');
        }

        $this->shopDomain = $shopDomain;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->shopDomain;
    }
}