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
