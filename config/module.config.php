<?php

use Zend\ServiceManager\Factory\InvokableFactory;
use ZfrShopify\Container\ShopifyClientFactory;
use ZfrShopify\Container\TokenExchangerFactory;
use ZfrShopify\OAuth\TokenExchanger;
use ZfrShopify\ShopifyClient;
use ZfrShopify\Validator\RequestValidator;
use ZfrShopify\Validator\WebhookValidator;

return [
    'dependencies' => [
        'factories' => [
            RequestValidator::class => InvokableFactory::class,
            WebhookValidator::class => InvokableFactory::class,
            ShopifyClient::class    => ShopifyClientFactory::class,
            TokenExchanger::class   => TokenExchangerFactory::class,
        ],
    ],
];
