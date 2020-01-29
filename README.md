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
php composer.phar require 'zfr/zfr-shopify:6.0'
```

## REST API

ZfrShopify provides a one-to-one mapping with API methods defined in [Shopify doc](https://docs.shopify.com/api/). Since the version 4, it also
supports a basic integration with the new GraphQL admin API.

### Private app

In order to use ZfrShopify as a private app, you must first instantiate the client:

```php
$shopifyClient = new ShopifyClient([
    'private_app' => true,
    'api_key'     => 'YOUR_API_KEY',
    'password'    => 'YOUR_PASSWORD',
    'shop'        => 'domain.myshopify.com',
    'version'     => '2019-04'
]);
```

> Make sure to always include a version. [More info about Shopify versioning](https://help.shopify.com/en/api/versioning)

### Public app

When using a public app, you instantiate the client a bit differently:
 
```php
$shopifyClient = new ShopifyClient([
    'private_app'   => false,
    'api_key'       => 'YOUR_API_KEY', // In public app, this is the app ID
    'access_token'  => 'MERCHANT_TOKEN',
    'shop'          => 'merchant.myshopify.com',
    'version'       => '2019-04'
]);
```

> Make sure to always include a version. [More info about Shopify versioning](https://help.shopify.com/en/api/versioning)

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
use ZfrShopify\Validator\ApplicationProxyRequestValidator;

$validator = new ApplicationProxyRequestValidator();

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

#### Count

Similarily, when you use one of the `count` endpoint, ZfrShopify will automatically extract the value from Shopify's response, so you do not need
to manually access the count property:

``php
$count = $shopifyClient->getOrderCount();
// $count is already an integer
``

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

## GraphQL API

In 2018, Shopify launched a new API, called the [GraphQL Admin API](https://help.shopify.com/en/api/graphql-admin-api). This new API comes with a lot of
advantages compared to the REST API:

* It allows to access more efficiently to the various Shopify resources (you can for instance get a collection, with all its products and variants, by
using a single request).
* It offers access to some resources that are not exposed through the REST API.

The version 4 of ZfrShopify now ships with a basic GraphQL client. It does not yet support the following features, though:

* Automatic pagination
* Automatic handling of Shopify rate limits

In order to use the client, you must instantiate it. Instead of the ShopifyClient, you must create a `ZfrShopify\ShopifyGraphQLClient`. If you are using
a private app:

```php
$client = new ShopifyGraphQLClient([
    'shop'        => 'test.myshopify.com',
    'version'     => '2019-04',
    'private_app' => true,
    'password'    => 'YOUR PASSWORD'
]);
```

> Make sure to always include a version. [More info about Shopify versioning](https://help.shopify.com/en/api/versioning)

If you are using a public app:

```php
$client = new ShopifyGraphQLClient([
    'shop'         => 'test.myshopify.com',
    'version'      => '2019-04',
    'private_app'  => false,
    'access_token' => 'ACCESS TOKEN'
]);
```

> Make sure to always include a version. [More info about Shopify versioning](https://help.shopify.com/en/api/versioning)

### Queries

To perform query, simply enter your query as an heredoc. For instance, here is a GraphQL query that get the title and id of the first 5 collections,
as well as the 5 first products within those collections (this used to require several queries in the REST API, while everything can be done very
efficiently with GraphQL):

```php
$request = <<<'EOT'
query
{
  collections(first: 5) {
    edges {
      node {
        id
        title
        products(first: 5) {
          edges {
            node {
              id
              title
            }
          }
        }
      }
    }
  }
}
EOT;

$result = $client->request($request);
```

ZfrShopify automatically unwrap the `data` top key from Shopify response, so you can retrieves the data like this:

```php
foreach ($result['collections']['edges'] as $collection) {
    var_dump('Collection title: ' . $collection['node']['title']);

    foreach ($collection['node']['products']['edges'] as $product) {
        var_dump('Product title: ' . $product['node']['title']);
    }
}
```

ZfrShopify does not attempt to re-write the GraphQL response.

#### Variables

ZfrShopify also fully supports GraphQL variable. For instance, here is how you can retrieve a given product by its ID by
using GraphQL variables:

```php
$request = <<<'EOT'
query getProduct($id: ID!)
{
  product(id: $id) {
    id
    title
  }
}
EOT;

$variables = [
    'id' => 'gid://shopify/Product/827442593835'
];

$result = $client->request($request, $variables);

var_dump($result);
``` 

### Mutations

Similarly, ZfrShopify supports mutation. To do this, you simply need to use a mutation query. Here is an example that
is creating a product:

```php
$request = <<<'EOT'
mutation createProduct($product: ProductInput!)
{
  productCreate(input: $product) {
    userErrors {
      field
      message
    }
    product {
      id
    }
  }
}
EOT;

$variables = [
    'product' => [
        'title' => 'My product'
    ]
];

$result = $client->request($request, $variables);

var_dump($result);
```

This request will create a new product whose title is "My product", and will return the id of the product.

> For better error handling, you should always include the userErrors object in your response.

### Error handling

When using GraphQL requests, there are two kinds of errors that you can catch.

#### Request errors

Those errors are for malformed GraphQL requests. You can catch them using the `\ZfrShopify\Exception\GraphQLErrorException` exception:

```php
try {
    $result = $client->request($request);
} catch (\ZfrShopify\Exception\GraphQLErrorException $exception) {
    var_dump($exception->getErrors());
}
```

#### User errors

Those errors are for requests that are missing data (like incorrect data, missing data...). You can catch them using the 
`\ZfrShopify\Exception\GraphQLUserErrorException` exception:

```php
try {
    $result = $client->request($request);
} catch (\ZfrShopify\Exception\GraphQLUserErrorException $exception) {
    var_dump($exception->getErrors());
}
```

## Implemented endpoints

Here is a list of supported endpoints (more to come in the future):

**ACCESS SCOPE RELATED METHODS:**

* array getAccessScopes(array $args = [])

** APPLICATION CHARGE RELATED METHODS:**

* array getApplicationCharges(array $args = [])
* array getApplicationCharge(array $args = [])
* array createApplicationCharge(array $args = [])
* array activateApplicationCharge(array $args = [])
* array deleteApplicationCharge(array $args = [])

**ARTICLE RELATED METHODS:**

* array getArticles(array $args = [])
* int getArticleCount(array $args = [])
* array getBlogArticles(array $args = [])
* int getBlogArticleCount(array $args = [])
* array getArticle(array $args = [])
* array getArticleMetafields(array $args = [])
* array getBlogArticle(array $args = [])
* array getArticlesAuthors(array $args = [])
* array getArticlesTags(array $args = [])
* array createArticle(array $args = [])
* array createBlogArticle(array $args = [])
* array updateArticle(array $args = [])
* array updateBlogArticle(array $args = [])
* array deleteArticle(array $args = [])
* array deleteBlogArticle(array $args = [])

**ASSET RELATED METHODS:**

* array getAssets(array $args = [])
* array getAsset(array $args = [])
* array createAsset(array $args = [])
* array updateAsset(array $args = [])
* array deleteAsset(array $args = [])

**BLOG RELATED METHODS:**

* array getBlogs(array $args = [])
* int getBlogCount(array $args = [])
* array getBlog(array $args = [])
* array createBlog(array $args = [])
* array updateBlog(array $args = [])
* array deleteBlog(array $args = [])

**CUSTOM COLLECTION RELATED METHODS:**

* array getCustomCollections(array $args = [])
* int getCustomCollectionCount(array $args = [])
* array getCustomCollection(array $args = [])
* array createCustomCollection(array $args = [])
* array updateCustomCollection(array $args = [])
* array deleteCustomCollection(array $args = [])

**COLLECTION RELATED METHODS**
* array getCollection(array $args = [])
* array getCollectionProducts(array $args = [])

**COLLECT RELATED METHODS:**

* array getCollects(array $args = [])
* int getCollectCount(array $args = [])
* array getCollect(array $args = [])
* array createCollect(array $args = [])
* array deleteCollect(array $args = [])

**CUSTOMER RELATED METHODS:**

* array getCustomers(array $args = [])
* int getCustomerCount(array $args = [])
* array searchCustomers(array $args = [])
* array getCustomer(array $args = [])
* array getCustomerMetafields(array $args = [])
* array createCustomer(array $args = [])
* array updateCustomer(array $args = [])
* array deleteCustomer(array $args = [])

**DISCOUNT CODE RELATED METHODS:**

* array getDiscountCodes(array $args = [])
* array getDiscountCode(array $args = [])
* array createDiscountCode(array $args = [])
* array deleteDiscountCode(array $args = [])

**EVENT RELATED METHODS:**

* array getEvents(array $args = [])
* int getEventCount(array $args = [])
* array getEvent(array $args = [])

**FULFILLMENTS RELATED METHODS:**

* array getFulfillments(array $args = [])
* int getFulfillmentCount(array $args = [])
* array getFulfillment(array $args = [])
* array createFulfillment(array $args = [])
* array updateFilfillment(array $args = [])
* array completeFulfillment(array $args = [])
* array cancelFulfillment(array $args = []) 

**GIFT CARD RELATED METHODS:**

* array getGiftCards(array $args = [])
* int getGiftCardCount(array $args = [])
* array getGiftCard(array $args = [])
* array createGiftCard(array $args = [])
* array updateGiftCard(array $args = [])
* array disableGiftCard(array $args = [])

**INVENTORY ITEM RELATED METHODS:**

* array getInventoryItems(array $args = [])
* array getInventoryItem(array $args = [])
* array updateInventoryItem(array $args = [])

**INVENTORY LEVEL RELATED METHODS:**

* array getInventoryLevels(array $args = [])
* array adjustInventoryLevel(array $args = [])
* array deleteInventoryLevel(array $args = [])
* array connectInventoryLevel(array $args = [])
* array setInventoryLevel(array $args = [])

**LOCATION RELATED METHODS:**

* array getLocations(array $args = [])
* array getLocation(array $args = [])
* int getLocationCount(array $args = [])
* array getLocationInventoryLevels(array $args = [])

**METAFIELDS RELATED METHODS:**

* array getMetafields(array $args = [])
* array getMetafield(array $args = [])
* array createMetafield(array $args = [])
* array updateMetafield(array $args = [])
* array deleteMetafield(array $args = [])

**ORDER RELATED METHODS:**

* array getOrders(array $args = [])
* int getOrderCount(array $args = [])
* array getOrder(array $args = [])
* array getOrderMetafields(array $args = [])
* array createOrder(array $args = [])
* array updateOrder(array $args = [])
* array closeOrder(array $args = [])
* array openOrder(array $args = [])
* array cancelOrder(array $args = [])

**DRAFT ORDER RELATED METHODS:**

* array getDraftOrders(array $args = [])
* int getDraftOrderCount(array $args = [])
* array createDraftOrder(array $args = [])
* array updateDraftOrder(array $args = [])
* array getDraftOrder(array $args = []) 
* array sendDraftOrderInvoice(array $args = [])
* array completeDraftOrder(array $args = [])
* array deleteDraftOrder(array $args = [])

**PAGE RELATED METHODS:**

* array getPages(array $args = [])
* int getPageCount(array $args = [])
* array getPage(array $args = [])
* array getPageMetafields(array $args = [])
* array createPage(array $args = [])
* array updatePage(array $args = [])
* array deletePage(array $args = [])

**PRICE RULE RELATED METHODS:**

* array getPriceRules(array $args = [])
* array getPriceRule(array $args = [])
* array createPriceRule(array $args = [])
* array updatePriceRule(array $args = [])
* array deletePriceRule(array $args = [])

**PRODUCT RELATED METHODS:**

* array getProducts(array $args = [])
* int getProductCount(array $args = [])
* array getProduct(array $args = [])
* array getProductMetafields(array $args = [])
* array createProduct(array $args = [])
* array updateProduct(array $args = [])
* array deleteProduct(array $args = [])

**PRODUCT IMAGE RELATED METHODS:**

* array getProductImages(array $args = [])
* int getProductImageCount(array $args = [])
* array getProductImage(array $args = [])
* array createProductImage(array $args = [])
* array updateProductImage(array $args = [])
* array deleteProductImage(array $args = [])

**RECURRING APPLICATION CHARGE RELATED METHODS:**

* array getRecurringApplicationCharges(array $args = [])
* array getRecurringApplicationCharge(array $args = [])
* array createRecurringApplicationCharge(array $args = [])
* array activateRecurringApplicationCharge(array $args = [])
* array deleteRecurringApplicationCharge(array $args = [])

**REFUND RELATED METHODS:**

* array getRefunds(array $args = [])
* array getRefund(array $args = [])
* array calculateRefund(array $args = [])
* array createRefund(array $args = [])

**SHOP RELATED METHODS:**

* array getShop(array $args = [])

**SMART COLLECTION RELATED METHODS:**

* array getSmartCollections(array $args = [])
* int getSmartCollectionCount(array $args = [])
* array getSmartCollection(array $args = [])
* array createSmartCollection(array $args = [])
* array updateSmartCollection(array $args = [])
* array deleteSmartCollection(array $args = [])

**THEME RELATED METHODS:**

* array getThemes(array $args = [])
* array getTheme(array $args = [])
* array createTheme(array $args = [])
* array updateTheme(array $args = [])
* array deleteTheme(array $args = [])

**PRODUCT VARIANT RELATED METHODS:**

* array getProductVariants(array $args = [])
* int getProductVariantCount(array $args = [])
* array getProductVariant(array $args = [])
* array getProductVariantMetafields(array $args = [])
* array createProductVariant(array $args = [])
* array updateProductVariant(array $args = [])
* array deleteProductVariant(array $args = [])

**REDIRECT RELATED METHODS:**

* array getRedirects(array $args = [])
* int getRedirectCount(array $args = [])
* array getRedirect(array $args = [])
* array createRedirect(array $args = [])
* array updateRedirect(array $args = [])
* array deleteRedirect(array $args = [])

**SCRIPT TAG RELATED METHODS:**

* array getScriptTags(array $args = [])
* int getScriptTagCount(array $args = [])
* array getScriptTag(array $args = [])
* array createScriptTag(array $args = [])
* array updateScriptTag(array $args = [])
* array deleteScriptTag(array $args = [])

**TRANSACTION RELATED METHODS:**

* array getTransactions(array $args = [])
* int getTransactionCount(array $args = [])
* array getTransaction(array $args = [])
* array createTransaction(array $args = [])

**USAGE CHARGE RELATED METHODS:**

* array getUsageCharges(array $args = [])
* array getUsageCharge(array $args = [])
* array createUsageCharge(array $args = [])

**WEBHOOK RELATED METHODS:**

* array getWebhooks(array $args = [])
* int getWebhookCount(array $args = [])
* array getWebhook(array $args = [])
* array createWebhook(array $args = [])
* array updateWebhook(array $args = [])
* array deleteWebhook(array $args = [])

**OTHER METHODS:**

* array createDelegateAccessToken(array $args = [])
