ZfrShopify
==========

[![Latest Stable Version](https://poser.pugx.org/zfr/zfr-shopify/v/stable.png)](https://packagist.org/packages/zfr/zfr-shopify)
[![Build Status](https://travis-ci.org/zf-fr/zfr-shopify.svg)](https://travis-ci.org/zf-fr/zfr-shopify)

ZfrShopify is a modern PHP library based on Guzzle for [Shopify](https://www.shopify.com).

## Dependencies

* PHP 7
* [Guzzle](http://www.guzzlephp.org): ^6.1
* [Zend Diactoros](https://github.com/zendframework/zend-diactoros): >=1.3

## Installation

Installation of ZfrShopify is only officially supported using Composer:

```sh
php composer.phar require 'zfr/zfr-shopify:3.0'
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

If you're using Zend\ServiceManager 3, you can use [Zend\ComponentInstaller](https://zendframework.github.io/zend-component-installer/)
to register our factories into Zend\ServiceManager automatically.

However if you're using other framework or other container, you can still manually register our factories, they are
under [src/Container](/src/Container) folder.

### Validating a request

ZfrShopify client provides an easy way to validate an incoming request to make sure it comes from Shopify through the `RequestValidator`
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

### Validating an application request

Finally, you can also use the `ApplicationProxyRequestValidator` to validate application proxy requests:


```php
use ZfrShopify\Exception\InvalidApplicationProxyRequestException;
use ZfrShopify\Validator\ApplicationProxyRequestException;

$validator = new RequestValidator();

try {
  $validator->validateApplicationProxyRequest($psr7Request, 'shared_secret');
} catch {
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

### Using iterators

For most "list" endpoints (`getProducts`, `getCollections`...), Shopify allows you to get up to 250 resources at a time. When using the standard `get**`
method, you are responsible to handle the pagination yourself.

For convenience, ZfrShopify allows you to easily iterate through all resources efficiently (internally, we are using generators). Here is how you can
get all the products from a given store:

```php
foreach ($shopifyClient->getProductsIterator(['fields' => 'id,title']) as $product) {
   // Do something with product
}
```

ZfrShopify will take care of doing additional requests when it has reached the end of a given page.

> If you are using the `fields` attribute to restrict the number of fields returned by Shopify, make sure that you are including at least the `id`
attribute, as internally ZfrShopify uses it.

### Executing multiple requests concurrently

For optimization purposes, it may be desirable to execute multiple requests concurrently. To do that, ZfrShopify client allow you to take advantage of
the underlying Guzzle client and execute multiple requests at the same time.

To do that, you can manually create the Guzzle commands, and execute them all. ZfrShopify will take care of authenticating all requests individually, and
extracting the response payload. For instance, here is how you could get both shop info and products info:

```php
$command1 = $client->getCommand('GetShop', ['fields' => 'id']);
$command2 = $client->getCommand('GetProducts', ['fields' => 'id,title']);

$results = $client->executeAll([$command1, $command2]);

// $results[0] represents the response of $command1, $results[1] represents the response of $command2
```

If a request has failed, it will contain an instance of `GuzzleHttp\Command\Exception\CommandException`. For instance, here is how you could iterate
through all the results:

```php
use GuzzleHttp\Command\Exception\CommandException;

foreach ($results as $singleResult) {
   if ($singleResult instanceof CommandException) {
     // Get the command that has failed, and eventually retry
     $command = $singleResult->getCommand();
     continue;
   }
   
   // Otherwise, $singleResult is just an array that contains the Shopify data
}
```

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
* createBlogArticle(array $args = [])
* updateArticle(array $args = [])
* updateBlogArticle(array $args = [])
* deleteArticle(array $args = [])
* deleteBlogArticle(array $args = [])

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

**CUSTOMER RELATED METHODS:**

* getCustomers(array $args = [])
* searchCustomers(array $args = [])
* getCustomer(array $args = [])
* createCustomer(array $args = [])
* updateCustomer(array $args = [])
* deleteCustomer(array $args = [])

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

**GIFT CARD RELATED METHODS:**

* getGiftCards(array $args = [])
* getGiftCard(array $args = [])
* createGiftCard(array $args = [])
* updateGiftCard(array $args = [])
* disableGiftCard(array $args = [])

**METAFIELDS RELATED METHODS:**

* array getMetafields(array $args = [])
* array getMetafield(array $args = [])
* array createMetafield(array $args = [])
* array updateMetafield(array $args = [])
* array deleteMetafield(array $args = [])

**ORDER RELATED METHODS:**

* array getOrders(array $args = [])
* array getOrder(array $args = [])
* array createOrder(array $args = [])
* array updateOrder(array $args = [])
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

**REFUND RELATED METHODS:**

* getRefunds(array $args = [])
* getRefund(array $args = [])
* calculateRefund(array $args = [])
* createRefund(array $args = [])

**SHOP RELATED METHODS:**

* getShop(array $args = [])

**SMART COLLECTION RELATED METHODS:**

* getSmartCollections(array $args = [])
* getSmartCollection(array $args = [])
* createSmartCollection(array $args = [])
* updateSmartCollection(array $args = [])
* deleteSmartCollection(array $args = [])

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

**REDIRECT RELATED METHODS:**

* getRedirects(array $args = [])
* getRedirect(array $args = [])
* createRedirect(array $args = [])
* updateRedirect(array $args = [])
* deleteRedirect(array $args = [])

**SCRIPT TAG RELATED METHODS:**

* getScriptTags(array $args = [])
* getScriptTag(array $args = [])
* createScriptTag(array $args = [])
* updateScriptTag(array $args = [])
* deleteScriptTag(array $args = [])

**TRANSACTION RELATED METHODS:**

* getTransactions(array $args = [])
* getTransaction(array $args = [])
* createTransaction(array $args = [])

**USAGE CHARGE RELATED METHODS:**

* getUsageCharges(array $args = [])
* getUsageCharge(array $args = [])
* createUsageCharge(array $args = [])

**WEBHOOK RELATED METHODS:**

* getWebhooks(array $args = [])
* getWebhook(array $args = [])
* createWebhook(array $args = [])
* updateWebhook(array $args = [])
* deleteWebhook(array $args = [])

**OTHER METHODS:**

* createDelegateAccessToken(array $args = [])
