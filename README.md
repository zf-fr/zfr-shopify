ZfrShopify
==========

[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-shopify/v/stable.png)](https://packagist.org/packages/zfr/zfr-shopify)
[![Build Status](https://travis-ci.org/zf-fr/zfr-shopify.svg)](https://travis-ci.org/zf-fr/zfr-shopify)

ZfrShopify is a modern PHP library based on Guzzle for [Shopify](https://www.shopify.com).

## Dependencies

* PHP 7
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
    'access_token'  => 'MERCHANT_TOKEN',
    'shop'          => 'merchant.myshopify.com'
]);
```

Most of the time, you will need to alter the client once you have retrieved the shop info. To that extent, the client offers
two public methods:

```php
$shopifyClient->setShopDomain('merchant.myshopify.com');
$shopifyClient->setAccessToken('your_access_token');
```

### Using a container

ZfrShopify also provides built-in [container-interop](https://github.com/container-interop/container-interop) factories
that you can use. You must make sure that your container contains a service called "config" that is an array with a key
`zfr_shopify` containing the required config:

```php
// myconfig.php

return [
    'zfr_shopify' => [
        'private_app'   => false,
        'api_key'       => 'YOUR_API_KEY', // In public app, this is the app ID
        'access_token'  => 'MERCHANT_TOKEN',
        'shop'          => 'merchant.myshopify.com',
    ],
];
```

If you're using Zend\Expressive with Zend\ServiceManager 3, you can use `ZfrShopify\ModuleConfig` to register our
factories into Zend\ServiceManager automatically.
More info [here](http://zendframework.github.io/zend-expressive/cookbook/modular-layout/)

However if you're using other framework or other container, you can still manually register our factories, they are
under [src/Container](/src/Container) folder.

### Validating a request

ZfrShopify client provides an easy way to validate an incoming request to make sure it provides from Shopify through the `RequestValidator`
object. It requires a PSR7 requests and a shared secret:

```php
use ZfrShopify\Exception\InvalidRequestException;
use ZfrShopify\Validator\RequestValidator;

$validator = new RequestValidator();

try {
    $validator->validateRequest($psr7Request, 'shared_secret');
} catch (InvalidRequestException $exception) {
    // Request is not valid
}
```

### Validating a webhook

Similarily, you can use the `WebhookValidator` to validate your webhook:

```php
use ZfrShopify\Exception\InvalidWebhookException;
use ZfrShopify\Validator\WebhookValidator;

$validator = new WebhookValidator();

try {
    $validator->validateWebhook($psr7Request, 'shared_secret');
} catch (InvalidWebhookException $exception) {
    // Request is not valid
}
```

### Create an authorization response

ZfrShopify provides an easy way to create a PSR7 compliant `ResponseInterface` to create an authorization response: 

```php
use ZfrShopify\OAuth\AuthorizationRedirectResponse;

$apiKey         = 'app_123';
$shopDomain     = 'shop_to_authorize.myshopify.com';
$scopes         = ['read_orders', 'read_products'];
$redirectionUri = 'https://myapp.test.com/oauth/redirect';
$nonce          = 'strong_nonce';

$response = new AuthorizationRedirectResponse($apiKey, $shopDomain, $scopes, $redirectionUri, $nonce);
```

While the `nonce` parameter is required, ZfrShopify does not make any assumption about how to save the nonce and check it when
Shopify redirects to your server. You are responsible to safely saving the nonce.

### Exchanging a code against an access token

You can use the `TokenExchanger` class to exchange a code to a long-lived access token:

```php
use GuzzleHttp\Client;
use ZfrShopify\OAuth\TokenExchanger;

$apiKey         = 'app_123';
$sharedSecret   = 'secret_123';
$shopDomain     = 'shop_to_authorize.myshopify.com';
$code           = 'code_123';

$tokenExchanger = new TokenExchanger(new Client());
$accessToken    = $tokenExchanger->exchangeCodeForToken($apiKey, $sharedSecret, $shopDomain, $code);
```

ZfrShopify also provides a simple factory compliant with [container-interop](https://github.com/container-interop/container-interop)
that you can register to the container of your choice, with the `ZfrShopify\Container\TokenExchangerFactory`.

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
* getBlogArticles(array $args = [])
* getArticle(array $args = [])
* getBlogArticle(array $args = [])
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

**FULFILLMENTS RELATED METHODS:**

* getFulfillments(array $args = [])
* getFulfillment(array $args = [])
* createFulfillment(array $args = [])
* updateFilfillment(array $args = [])
* completeFulfillment(array $args = [])
* cancelFulfillment(array $args = []) 

**METAFIELDS RELATED METHODS:**

* array getMetafields(array $args = [])
* array getMetafield(array $args = [])
* array createMetafield(array $args = [])
* array updateMetafield(array $args = [])
* array deleteMetafield(array $args = [])

**ORDER RELATED METHODS:**

* array getOrders(array $args = [])
* array getOrder(array $args = [])
* array closeOrder(array $args = [])
* array openOrder(array $args = [])
* array cancelOrder(array $args = [])

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

**PRODUCT VARIANT RELATED METHODS:**

* getProductVariants(array $args = [])
* getProductVariant(array $args = [])
* createProductVariant(array $args = [])
* updateProductVariant(array $args = [])
* deleteProductVariant(array $args = [])

**WEBHOOK RELATED METHODS:**

* getWebhooks(array $args = [])
* getWebhook(array $args = [])
* createWebhook(array $args = [])
* updateWebhook(array $args = [])
* deleteWebhook(array $args = [])