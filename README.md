ZfrShopify
==========

[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-shopify/v/stable.png)](https://packagist.org/packages/zfr/zfr-shopify)
[![Build Status](https://travis-ci.org/zf-fr/zfr-shopify.svg)](https://travis-ci.org/zf-fr/zfr-shopify)

ZfrShopify is a modern PHP library based on Guzzle for [Shopify](https://www.shopify.com).

## Dependencies

* PHP 5.6+
* [Guzzle](http://www.guzzlephp.org): >= 3.6
* [Zend Diactoros](https://github.com/zendframework/zend-diactoros): >=1.1

## Installation

Installation of ZfrShopify is only officially supported using Composer:

```sh
php composer.phar require 'zfr/zfr-shopify:0.1.*'
```

## Usage

ZfrShopify provides a one-to-one mapping with API methods defined in [Shopify doc](https://docs.shopify.com/api/).

### Private app

In order to use ZfrShopify as a private app, you must first instantiate the client:

```php
$shopifyClient = new ShopifyClient([
    'private_app' => true,
    'api_key'     => 'YOUR_API_KEY',
    'password'    => 'YOUR_PASSWORD',
    'shop'        => 'domain.myshopify.com'
]);
```

### Public app

When using a public app, you instantiate the client a bit differently:
 
```php
$shopifyClient = new ShopifyClient([
    'private_app'   => false,
    'api_key'       => 'YOUR_API_KEY', // In public app, this is the app ID
    'shared_secret' => 'YOUR_SHARED_SECRET',
    'access_token'  => 'MERCHANT_TOKEN',
    'shop'          => 'merchant.myshopify.com'
]);
```

The `shared_secret` is needed so you can exchange an authorization code for an access token during the OAuth dance, while the
`access_token` is the long lived token you receive.

Most of the time, you will need to alter the client once you have retrieved the shop info. To that extent, the client offers
two public methods:

```php
$shopifyClient->setShopDomain('merchant.myshopify.com');
$shopifyClient->setAccessToken('your_access_token');
```

### Using a container

ZfrShopify also provides a built-in `InteropContainer` factory that you can use. You must make sure to provide a config with
a top key `config` and sub-key `zfr_shopify`:

```php
// myconfig.php

return [
    'config' => [
        'zfr_shopify' => [
            'private_app'   => false,
            'api_key'       => 'YOUR_API_KEY', // In public app, this is the app ID
            'shared_secret' => 'YOUR_SHARED_SECRET',
            'access_token'  => 'MERCHANT_TOKEN',
            'shop'          => 'merchant.myshopify.com'
        ]
    ]
];
```

### Validating a request

ZfrShopify client provides an easy way to validate an incoming request to make sure it provides from Shopify. It accepts a
PSR-7 request:

```php
use ZfrShopify\Exception\InvalidRequestException;

try {
    $shopifyClient->validateRequest($psr7Request);
} catch (InvalidRequestException $exception) {
    // Request is not valid
}
```

### Validating a webhook

Similarily, the client provides an easy way to validate an incoming request for webhooks:

```php
use ZfrShopify\Exception\InvalidWebhookException;

try {
    $shopifyClient->validateWebhook($psr7Request);
} catch (InvalidWebhookException $exception) {
    // Request is not valid
}
```

### Create an authorization response

Under the hood, ZfrShopify uses [Zend\Diactoros](https://github.com/zendframework/zend-diactoros) as a PSR7 implementation. It can
creates a response properly filled for creating an authorization response during the OAuth dance:

```php
$shopDomain     = 'shop_to_authorize.myshopify.com';
$scopes         = ['read_orders', 'read_products'];
$redirectionUri = 'https://myapp.test.com/oauth/redirect';
$nonce          = 'strong_nonce';

$response = $shopifyClient->createAuthorizationResponse($shopDomain, $scopes, $redirectionUri, $nonce);
```

While the `nonce` parameter is required, ZfrShopify does not make any assumption about how to save the nonce and check it when
Shopify redirects to your server. You are responsible to safely saving the nonce.

### Exploiting responses

ZfrShopify returns Shopify response directly. However, by default, Shopify wrap the responses by a top-key. For instance, if
you want to retrieve shop information, Shopify will return this payload:

```json
{
    "shop": {
        "id": 123,
        "domain": "myshop.myshopify.com"
    }
}
```

This is a bit inconvenient to use as we would need to do that:

```php
$shopDomain = $shopifyClient->getShop()['shop']['domain'];
```

Instead, ZfrShopify automatically "unwraps" response, so you can use the more concise code:

```php
$shopDomain = $shopifyClient->getShop()['domain'];
```

When reading Shopify API doc, make sure you remove the top key when exploiting responses.

## Implemented endpoints

Here is a list of supported endpoints (more to come in the future):

**ARTICLE RELATED METHODS:**

* getArticles(array $args = [])
* getArticle(array $args = [])
* getArticlesAuthors(array $args = [])
* getArticlesTags(array $args = [])
* createArticle(array $args = [])
* updateArticle(array $args = [])
* deleteArticle(array $args = [])

**ASSET RELATED METHODS:**

* getAssets(array $args = [])
* getAsset(array $args = [])
* createAsset(array $args = [])
* updateAsset(array $args = [])
* deleteAsset(array $args = [])

**CUSTOM COLLECTION RELATED METHODS:**

* getCustomCollections(array $args = [])
* getCustomCollection(array $args = [])
* createCustomCollection(array $args = [])
* updateCustomCollection(array $args = [])
* deleteCustomCollection(array $args = [])

**EVENT RELATED METHODS:**

* getEvents(array $args = [])
* getEvent(array $args = [])

**ORDER RELATED METHODS:**

* array getOrders(array $args = [])

**PAGE RELATED METHODS:**

* getPages(array $args = [])
* getPage(array $args = [])
* createPage(array $args = [])
* updatePage(array $args = [])
* deletePage(array $args = [])

**PRODUCT RELATED METHODS:**

* getProducts(array $args = [])
* getProduct(array $args = [])
* createProduct(array $args = [])
* updateProduct(array $args = [])
* deleteProduct(array $args = [])

**PRODUCT IMAGE RELATED METHODS:**

* getProductImages(array $args = [])
* getProductImage(array $args = [])
* createProductImage(array $args = [])
* updateProductImage(array $args = [])
* deleteProductImage(array $args = [])

**RECURRING APPLICATION CHARGE RELATED METHODS:**

* getRecurringApplicationCharges(array $args = [])
* getRecurringApplicationCharge(array $args = [])
* createRecurringApplicationCharge(array $args = [])
* activateRecurringApplicationCharge(array $args = [])
* deleteRecurringApplicationCharge(array $args = [])

**SHOP RELATED METHODS:**

* getShop(array $args = [])

**THEME RELATED METHODS:**

* getThemes(array $args = [])
* getTheme(array $args = [])
* createTheme(array $args = [])
* updateTheme(array $args = [])
* deleteTheme(array $args = [])

**WEBHOOK RELATED METHODS:**

* getWebhooks(array $args = [])
* getWebhook(array $args = [])
* createWebhook(array $args = [])
* updateWebhook(array $args = [])
* deleteWebhook(array $args = [])

**OAUTH RELATED METHODS:**

* exchangeCodeForToken(array $args = [])