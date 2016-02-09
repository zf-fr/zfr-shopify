<?php

require_once 'vendor/autoload.php';

$sh = new \ZfrShopify\ShopifyClient([
    'private_app' => true,
    'api_key'     => 'a9ff874f7fb5f4bc3ea4dc2fee21442b',
    'password'    => 'e8d5c744069062afd262ee946ed7ed19',
    'shop'        => 'maestrooo-playground.myshopify.com'
]);

var_dump($sh->getShop());