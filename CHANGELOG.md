# 6.0.0

* If you are using the 2020-01 API or newer for the REST API, it will now uses the link based pagination when the
iterator methods are used.

# 5.3.0

* Add collect endpoints

# 5.2.0

* Add blog count endpoint

# 5.1.0

* Add carrier service endpoints

# 5.0.0

* [BC] Add support for the new "version". You are now required to pass a version when creating a client (both admin
  and GraphQL API).
* Fix GraphQL doc

# 4.2.0

* Add blog methods

# 4.1.0

* Add draft order methods

# 4.0.0

* Remove unused dev dependency
* Allow to use Zend Diactoros 2.x
* Update dependency to use PSR-11 interfaces instead of container interop
* Add access scopes methods
* Add application charge methods
* Add new webhooks
* Add discount code and price rules methods
* Provide a basic client for the new GraphQL API

# 3.5.0

* Add missing updateOrder method to the descriptor

# 3.4.1

* Fix an issue where additional parameters couldn't be pass when creating webhooks

# 3.4.0

* Add support for inventory levels

# 3.3.2

* Remove default argument for __call

# 3.3.1

* Fix an issue with the CreateUsageCharge command

# 3.3.0

* Add dedicated metafields namespace (`getArticleMetafields`...)

# 3.2.0

* Add a new `count` endpoint for each resource. For instance you can get the number of orders this way:

```php
$count = $shopifyClient->getOrderCount();
```

ZfrShopify automatically processes the response returned from Shopify to return you an integer.

# 3.1.0

* Add a new validator that can be used to validate incoming application proxy requests

# 3.0.1

* Fix an issue with paginating gift cards.

# 3.0.0

* ZfrShopify no longer explicitly specifies all the parameters in the descriptor. Instead, only the required fields are still validated, while others
parameters are all passed to Shopify API. The reason was that Shopify API is moving fast, and keeping up to date with all the new attributes (or missing ones)
was too time consuming. We lost a lot of hours of work trying to figure out why some of our API calls didn't work as expected, just to figure out that it was
because we forgot the property in the descriptor.

This change should make the maintenance much easier, and allow people to use last Shopify features without waiting for an upgrade of this package.

It should not cause any BC break, except that validation will no longer be performed on optional fields, but to be on the safe side, this version is now
tagged as 3.0.

# 2.2.9

* Add `SearchCustomers` endpoint.

# 2.2.8

* Make `email` optional when creating customer.

# 2.2.7

* Add `send_receipt` and `send_fulfillment_receipt` when creating order.

# 2.2.6

* Add the `expires_on` property for gift card.

# 2.2.5

* Add redirect endpoints.

# 2.2.4

* Allow to pass `metafield_namespaces` when creating or updating webhooks.

# 2.2.3

* Add an `UpdateOrder` endpoint

# 2.2.2

* Retry in case of 5XX response.

# 2.2.1

* Simplified the `UpdateProductVariant` by no longer needing the product ID (variant ID is enough).

# 2.2.0

* Add customer endpoints.

# 2.1.2

* Add a `name` filter for the `getOrders` endpoint that allows to filter by order number.

# 2.1.1

* Fix a bug in the `createCustomCollection` and `createSmartCollection` endpoints that prevented to use them.
* Update the semantic of the Guzzle service description to more closely reflect the nature of some properties.

# 2.1.0

* Add new `getCommand`, `execute` and `executeAll` methods which proxy to Guzzle client equivalent methods and allow more advanced use cases
such as executing multiple commands concurrently.

# 2.0.0

* Update dependencies to use the more recent Guzzle 6 service
* Improve iterators performance by using generators
* Add a basic retry policy for better resiliency against Shopify API rate limits
* Removing the ability to alter a client using setters. A client is now immutable ; you need to create a new one if you need it configured with
a different set of data.

# 1.5.0

* Add support for script tag methods (https://help.shopify.com/api/reference/scripttag)
* Fix the "attachment" parameter for theme assets

# 1.4.0

* Add support for order transaction methods (https://help.shopify.com/api/reference/transaction)

# 1.3.0

* Added new endpoint for accessing articles without the blog reference.

# 1.2.0

* Add support for usage charge methods (https://help.shopify.com/api/reference/usagecharge)

# 1.1.0

* Add `createDelegateAccessToken` endpoint ([more info on delegate tokens](https://help.shopify.com/api/guides/authentication/oauth#delegating-access-to-subsystems))

# 1.0.0

* First release
