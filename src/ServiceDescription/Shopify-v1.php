<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

return [
    'name'        => 'Shopify',
    'description' => 'Shopify is an awesome e-commerce platform',
    'operations'  => [
        /**
         * --------------------------------------------------------------------------------
         * ACCESS SCOPE RELATED METHODS
         *
         * DOC: https://help.shopify.com/en/api/reference/access/accessscope
         * --------------------------------------------------------------------------------
         */

        'GetAccessScopes' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/oauth/access_scopes.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of access scopes',
            'data'                 => ['root_key' => 'access_scopes'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * APPLICATION CHARGES RELATED METHODS
         *
         * DOC: https://help.shopify.com/en/api/reference/billing/applicationcharge
         * --------------------------------------------------------------------------------
         */

        'GetApplicationCharges' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/application_charges.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of application charges',
            'data'                 => ['root_key' => 'application_charges'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetApplicationCharge' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/application_charges/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific application charge',
            'data'             => ['root_key' => 'application_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/application_charges.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new application charge',
            'data'             => ['root_key' => 'application_charge'],
            'parameters'       => [
                'name' => [
                    'description' => 'Application charge name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'price' => [
                    'description' => 'Price to charge',
                    'location'    => 'json',
                    'type'        => 'number',
                    'required'    => true
                ],
                'return_url' => [
                    'description' => 'URL where Shopify must return once the charge has been accepted',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'ActivateApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/application_charges/{id}/activate.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Activate a previously accepted application charge',
            'data'             => ['root_key' => 'application_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * ARTICLE RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/article
         * --------------------------------------------------------------------------------
         */

        'GetArticles' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/articles.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of articles',
            'data'                 => ['root_key' => 'articles'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetArticleCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/articles/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of articles (for all blogs)',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetBlogArticles' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/blogs/{blog_id}/articles.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of articles for a given blog',
            'data'             => ['root_key' => 'articles'],
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetBlogArticleCount' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/blogs/{blog_id}/articles/count.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve the number of articles (for a single blog)',
            'parameters'    => [
                'blog_id' => [
                    'description' => 'Blog from which we need to count articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetArticle' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific article',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetArticleMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/articles/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for an article',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetBlogArticle' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/blogs/{blog_id}/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific article from a given blog',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'blog_id' => [
                    'description' => 'Blog ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetArticlesAuthors' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/articles/authors.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve list of all article authors',
            'data'          => ['root_key' => 'authors'],
        ],

        'GetArticlesTags' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/blogs/{blog_id}/articles/tags.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve all tags for a given blog',
            'data'             => ['root_key' => 'tags'],
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateArticle' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/articles.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new article',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'title' => [
                    'description' => 'Article title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'CreateBlogArticle' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/blogs/{blog_id}/articles.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new article',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Article title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateArticle' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing article',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateBlogArticle' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/blogs/{blog_id}/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing article',
            'data'             => ['root_key' => 'article'],
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteArticle' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing article',
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        'DeleteBlogArticle' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/blogs/{blog_id}/articles/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing article',
            'parameters'       => [
                'id' => [
                    'description' => 'Article ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * ASSETS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/asset
         * --------------------------------------------------------------------------------
         */

        'GetAssets' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/themes/{theme_id}/assets.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of assets for a given theme',
            'data'             => ['root_key' => 'assets'],
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetAsset' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/themes/{theme_id}/assets.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a single asset',
            'data'             => ['root_key' => 'asset'],
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'key' => [
                    'description' => 'Complete key of the asset file',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'asset[key]'
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateAsset' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/themes/{theme_id}/assets.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new asset in the given theme',
            'data'             => ['root_key' => 'asset'],
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'key' => [
                    'description' => 'Complete key of the asset file',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateAsset' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/themes/{theme_id}/assets.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new asset in the given theme',
            'data'             => ['root_key' => 'asset'],
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'key' => [
                    'description' => 'Complete key of the asset file',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteAsset' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/themes/{theme_id}/assets.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing asset',
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'key' => [
                    'description' => 'Complete key of the asset file',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'asset[key]'
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * CUSTOM COLLECTION RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/customcollection
         * --------------------------------------------------------------------------------
         */

        'GetCustomCollections' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/custom_collections.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of custom collections',
            'data'                 => ['root_key' => 'custom_collections'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetCustomCollectionCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/custom_collections/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of custom collections',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetCustomCollection' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/custom_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Custom collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateCustomCollection' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/custom_collections.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'title' => [
                    'description' => 'Custom collection title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateCustomCollection' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/custom_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update a custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Custom collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteCustomCollection' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/custom_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete a custom collection',
            'parameters'       => [
                'id' => [
                    'description' => 'Custom collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * CUSTOMER RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/customer
         * --------------------------------------------------------------------------------
         */

        'GetCustomers' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/customers.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of customers',
            'data'                 => ['root_key' => 'customers'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetCustomerCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/customers/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of customers',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'SearchCustomers' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/customers/search.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Searches for customers',
            'data'          => ['root_key' => 'customers'],
            'parameters'    => [
                'order' => [
                    'description' => 'Field and direction to order results by',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                ],
                'query' => [
                    'description' => 'Text to search customers',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ],
                'limit' => [
                    'description' => 'Amount of results',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false,
                ],
                'fields' => [
                    'description' => 'comma-separated list of fields to include in the response',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                ],
            ],
        ],

        'GetCustomer' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/customers/{id}.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Receive a single customer',
            'data'          => ['root_key' => 'customer'],
            'parameters'    => [
                'id' => [
                    'description' => 'Customer ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetCustomerMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/customers/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for a customer',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Customer ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateCustomer' => [
            'httpMethod'    => 'POST',
            'uri'           => 'admin/customers.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Create a new customer',
            'data'          => ['root_key' => 'customer'],
            'parameters'    => [
                'email' => [
                    'description' => 'The email address of the customer',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                ],
                'first_name' => [
                    'description' => 'The customer\'s first name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                ],
                'last_name' => [
                    'description' => 'The customer\'s last name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateCustomer' => [
            'httpMethod'    => 'PUT',
            'uri'           => 'admin/customers/{id}.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Modify an existing customer',
            'data'          => ['root_key' => 'customer'],
            'parameters'    => [
                'id' => [
                    'description' => 'Customer ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteCustomer' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/customers/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Remove a customer from the database',
            'parameters'       => [
                'id' => [
                    'description' => 'Customer ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * DISCOUNT CODE RELATED METHODS
         *
         * DOC: https://help.shopify.com/en/api/reference/discounts/discountcode
         * --------------------------------------------------------------------------------
         */

        'GetDiscountCodes' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/price_rules/{price_rule_id}/discount_codes.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of discount codes',
            'data'                 => ['root_key' => 'discount_codes'],
            'parameters'       => [
                'price_rule_id' => [
                    'description' => 'Price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetDiscountCode' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/price_rules/{price_rule_id}/discount_codes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific discount code',
            'data'             => ['root_key' => 'discount_code'],
            'parameters'       => [
                'price_rule_id' => [
                    'description' => 'Price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'id' => [
                    'description' => 'Specific discount code ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateDiscountCode' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/price_rules/{price_rule_id}/discount_codes.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new discount code for the given price rule',
            'data'             => ['root_key' => 'discount_code'],
            'parameters'       => [
                'price_rule_id' => [
                    'description' => 'Price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'code' => [
                    'description' => 'Code',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateDiscountCode' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/price_rules/{price_rule_id}/discount_codes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing discount code',
            'data'             => ['root_key' => 'discount_code'],
            'parameters'       => [
                'price_rule_id' => [
                    'description' => 'Price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'id' => [
                    'description' => 'Specific discount code ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteDiscountCode' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/price_rules/{price_rule_id}/discount_codes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing discount code',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific discount code ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * EVENTS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/events
         * --------------------------------------------------------------------------------
         */

        'GetEvents' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/events.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of events',
            'data'                 => ['root_key' => 'events'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetEventCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/events/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of events',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetEvent' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/events/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific event',
            'data'             => ['root_key' => 'event'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * FULFILLMENT RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/fulfillment
         * --------------------------------------------------------------------------------
         */

        'GetFulfillments' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{order_id}/fulfillments.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of fulfillments for a given order',
            'data'             => ['root_key' => 'fulfillments'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetFulfillmentCount' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{order_id}/fulfillments/count.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve the number of fulfillments',
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order from which we need to count fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetFulfillment' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{order_id}/fulfillments/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific order',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'id' => [
                    'description' => 'Fulfillment ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateFulfillment' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{order_id}/fulfillments.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a fulfillment for a given order',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateFulfillment' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/orders/{order_id}/fulfillments/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update a fulfillment for a given order',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'id' => [
                    'description' => 'Fulfillment ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'CompleteFulfillment' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{order_id}/fulfillments/{id}/complete.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Complete a pending fulfillment',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'id' => [
                    'description' => 'Fulfillment ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ]
        ],

        'CancelFulfillment' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{order_id}/fulfillments/{id}/cancel.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Cancel a pending fulfillment',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'id' => [
                    'description' => 'Fulfillment ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * GIFT CARD RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/gift_card
         * --------------------------------------------------------------------------------
         */

        'GetGiftCards' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/gift_cards.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Receive a list of all Gift Cards',
            'data'                 => ['root_key' => 'gift_cards'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetGiftCardCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/gift_cards/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of gift cards',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetGiftCard' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/gift_cards/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Receive a single Gift Card',
            'data'             => ['root_key' => 'gift_card'],
            'parameters'       => [
                'id' => [
                    'description' => 'Gift Card ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
        ],

        'CreateGiftCard' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/gift_cards.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new Gift Card',
            'data'             => ['root_key' => 'gift_card'],
            'parameters'       => [
                'initial_value' => [
                    'description' => 'The initial Gift Card value',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateGiftCard' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/gift_cards/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update the Gift Card',
            'data'             => ['root_key' => 'gift_card'],
            'parameters'       => [
                'id' => [
                    'description' => 'Gift Card ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DisableGiftCard' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/gift_cards/{id}/disable.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Disabling a Gift Card is permanent and cannot be undone',
            'data'             => ['root_key' => 'gift_card'],
            'parameters'       => [
                'id' => [
                    'description' => 'Gift Card ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * INVENTORY ITEM RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/inventory/inventoryitem
         * --------------------------------------------------------------------------------
         */

        'GetInventoryItems' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/inventory_items.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of inventory items by passed identifiers',
            'data'                 => ['root_key' => 'inventory_items'],
            'parameters'       => [
                'ids' => [
                    'description' => 'Comma seperated list of IDs',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ],
                'limit' => [
                    'description' => 'Amount of results',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false,
                ],
            ],
        ],

        'GetInventoryItem' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/inventory_items/{id}.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a specific inventory item',
            'data'                 => ['root_key' => 'inventory_item'],
            'parameters'       => [
                'id' => [
                    'description' => 'Inventory Item ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'UpdateInventoryItem' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/inventory_items/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update a specific inventory item',
            'data'             => ['root_key' => 'inventory_item'],
            'parameters'       => [
                'id' => [
                    'description' => 'Inventory Item ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * INVENTORY LEVEL RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/inventory/inventorylevel
         * --------------------------------------------------------------------------------
         */

        'GetInventoryLevels' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/inventory_levels.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of inventory levels either by passed inventory item IDs, location IDs or both',
            'data'                 => ['root_key' => 'inventory_levels'],
            'parameters'       => [
                'inventory_item_ids' => [
                    'description' => 'Comma seperated list of inventory item IDs',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                ],
                'location_ids' => [
                    'description' => 'Comma seperated list of location IDs',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                ],
                'limit' => [
                    'description' => 'Amount of results',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false,
                ],
            ],
        ],

        'AdjustInventoryLevel' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/inventory_levels/adjust.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Adjusts the inventory level of an inventory item at a single location',
            'parameters'       => [
                'inventory_item_id' => [
                    'description' => 'The inventory item id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'location_id' => [
                    'description' => 'The location id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'available_adjustment' => [
                    'description' => 'The amount to adjust the available inventory quantity',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ]
        ],

        'DeleteInventoryLevel' => [
            'httpMethod'    => 'DELETE',
            'uri'           => 'admin/inventory_levels.json',
            'responseModel' => 'GenericModel',
            'parameters'    => [
                'inventory_item_id' => [
                    'description' => 'The inventory item id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'location_id' => [
                    'description' => 'The location id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ]
        ],

        'ConnectInventoryLevel' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/inventory_levels/connect.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Connects an inventory item to a location by creating an inventory level at that location',
            'parameters'       => [
                'inventory_item_id' => [
                    'description' => 'The inventory item id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'location_id' => [
                    'description' => 'The location id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'relocate_if_necessary' => [
                    'description' => 'The amount to adjust the available inventory quantity',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => false,
                ],
            ]
        ],

        'SetInventoryLevel' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/inventory_levels/set.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Sets the inventory level for an inventory item at a location',
            'parameters'       => [
                'inventory_item_id' => [
                    'description' => 'The inventory item id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'location_id' => [
                    'description' => 'The location id',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'available' => [
                    'description' => 'Sets the available inventory quantity',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'disconnect_if_necessary' => [
                    'description' => 'Whether inventory for any previously connected locations will be set to 0 and the locations disconnected',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => false,
                ],
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * LOCATION RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/inventory/location
         * --------------------------------------------------------------------------------
         */

        'GetLocations' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/locations.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of locations',
            'data'                 => ['root_key' => 'locations'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetLocation' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/locations/{id}.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a specific location',
            'data'                 => ['root_key' => 'location'],
            'parameters'       => [
                'id' => [
                    'description' => 'Location ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetLocationCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/locations/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a count of locations',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetLocationInventoryLevels' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/locations/{id}/inventory_levels.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a specific location',
            'data'                 => ['root_key' => 'inventory_levels'],
            'parameters'       => [
                'id' => [
                    'description' => 'Location ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * METAFIELDS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/metafield
         * --------------------------------------------------------------------------------
         */

        'GetMetafields' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/metafields.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of metafields',
            'data'                 => ['root_key' => 'metafields'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetMetafield' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/metafields/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific metafield',
            'data'             => ['root_key' => 'metafield'],
            'parameters'       => [
                'id' => [
                    'description' => 'Metafield ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateMetafield' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/metafields.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new metafield',
            'data'             => ['root_key' => 'metafield'],
            'parameters'       => [
                'namespace' => [
                    'description' => 'Namespace to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'key' => [
                    'description' => 'Key to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'value' => [
                    'description' => 'Value type',
                    'location'    => 'json',
                    'type'        => ['string', 'integer'],
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateMetafield' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/metafields/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update a specific metafield',
            'data'             => ['root_key' => 'metafield'],
            'parameters'       => [
                'id' => [
                    'description' => 'Metafield ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'value' => [
                    'description' => 'Value type',
                    'location'    => 'json',
                    'type'        => ['string', 'integer'],
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteMetafield' => [
            'httpMethod'    => 'DELETE',
            'uri'           => 'admin/metafields/{id}.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Delete specific metafield',
            'parameters'    => [
                'id' => [
                    'description' => 'Metafield ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * ORDER RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/order
         * --------------------------------------------------------------------------------
         */

        'GetOrders' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/orders.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of orders',
            'data'                 => ['root_key' => 'orders'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetOrderCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/orders/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of orders',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetOrder' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetOrderMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/orders/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for an order',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'line_items' => [
                    'description' => 'The order line items',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'CloseOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{id}/close.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Close a specific order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        'OpenOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{id}/open.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Re-open a closed order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        'UpdateOrder' => [
          'httpMethod'           => 'PUT',
          'uri'                  => 'admin/orders/{id}.json',
          'responseModel'        => 'GenericModel',
          'summary'              => 'Update an existing order',
          'data'                 => ['root_key' => 'order'],
          'parameters'           => [
            'id' => [
              'description' => 'Order ID',
              'location'    => 'uri',
              'type'        => 'integer',
              'required'    => TRUE
            ],
          ],
          'additionalParameters' => [
            'location' => 'json',
          ],
        ],
        
        'CancelOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{id}/cancel.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Cancel a given order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * PAGE RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/page
         * --------------------------------------------------------------------------------
         */

        'GetPages' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/pages.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of pages',
            'data'                 => ['root_key' => 'pages'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetPageCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/pages/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of pages',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetPage' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/pages/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific page',
            'data'             => ['root_key' => 'page'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetPageMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/pages/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for a page',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreatePage' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/pages.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new page',
            'data'             => ['root_key' => 'page'],
            'parameters'       => [
                'title' => [
                    'description' => 'Page title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'body_html' => [
                    'description' => 'HTML content for the page',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdatePage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/pages/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing page',
            'data'             => ['root_key' => 'page'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeletePage' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/pages/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing page',
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PRODUCT RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/product
         * --------------------------------------------------------------------------------
         */

        'GetProducts' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/products.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of products',
            'data'                 => ['root_key' => 'products'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/products/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of products',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProduct' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/products/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for a product',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateProduct' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/products.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'title' => [
                    'description' => 'Product title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateProduct' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/products/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteProduct' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/products/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing product',
            'parameters'       => [
                'id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PRODUCT IMAGES RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/product_image
         * --------------------------------------------------------------------------------
         */

        'GetProductImages' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{product_id}/images.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of product images',
            'data'             => ['root_key' => 'images'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductImageCount' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{product_id}/images/count.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve the number of images for a given product',
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductImage' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{product_id}/images/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific product image',
            'data'             => ['root_key' => 'image'],
            'parameters'       => [
                'id' => [
                    'description' => 'Product image ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateProductImage' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/products/{product_id}/images.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new product image',
            'data'             => ['root_key' => 'image'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateProductImage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/products/{product_id}/images/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing product image',
            'data'             => ['root_key' => 'image'],
            'parameters'       => [
                'id' => [
                    'description' => 'Product image ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteProductImage' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/products/{product_id}/images/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing product image',
            'parameters'       => [
                'id' => [
                    'description' => 'Product image ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * RECURRING APPLICATION CHARGES RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/recurringapplicationcharge
         * --------------------------------------------------------------------------------
         */

        'GetRecurringApplicationCharges' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/recurring_application_charges.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of recurring application charges',
            'data'                 => ['root_key' => 'recurring_application_charges'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetRecurringApplicationCharge' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/recurring_application_charges/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific recurring application charge',
            'data'             => ['root_key' => 'recurring_application_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific recurring application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateRecurringApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/recurring_application_charges.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new recurring application charge',
            'data'             => ['root_key' => 'recurring_application_charge'],
            'parameters'       => [
                'name' => [
                    'description' => 'Plan name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'price' => [
                    'description' => 'Price to charge',
                    'location'    => 'json',
                    'type'        => 'number',
                    'required'    => true
                ],
                'return_url' => [
                    'description' => 'URL where Shopify must return once the charge has been accepted',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'ActivateRecurringApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/recurring_application_charges/{id}/activate.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Activate a previously accepted recurring application charge',
            'data'             => ['root_key' => 'recurring_application_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific recurring application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        'DeleteRecurringApplicationCharge' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/recurring_application_charges/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing recurring application charge',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific recurring application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * REFUND RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/refund
         * --------------------------------------------------------------------------------
         */

        'GetRefunds' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{order_id}/refunds.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of Refunds for an Order',
            'data'             => ['root_key' => 'refunds'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetRefund' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/orders/{order_id}/refunds/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific refund',
            'data'             => ['root_key' => 'refund'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'id' => [
                    'description' => 'Specific refund ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CalculateRefund' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{order_id}/refunds/calculate.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Calculate refund transactions based on line items and shipping',
            'data'             => ['root_key' => 'refund'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'CreateRefund' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/orders/{order_id}/refunds.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a Refund for an existing Order',
            'data'             => ['root_key' => 'refund'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * SHOP RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/shop
         * --------------------------------------------------------------------------------
         */

        'GetShop' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/shop.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Get data about a single shop',
            'data'                 => ['root_key' => 'shop'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * SMART COLLECTION RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/smartcollection
         * --------------------------------------------------------------------------------
         */

        'GetSmartCollections' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/smart_collections.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of smart collections',
            'data'                 => ['root_key' => 'smart_collections'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetSmartCollectionCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/smart_collections/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of smart collections',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetSmartCollection' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/smart_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve specific smart collection',
            'data'             => ['root_key' => 'smart_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Smart collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateSmartCollection' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/smart_collections.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a smart collection',
            'data'             => ['root_key' => 'smart_collection'],
            'parameters'       => [
                'title' => [
                    'description' => 'Smart collection title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateSmartCollection' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/smart_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update a smart collection',
            'data'             => ['root_key' => 'smart_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Smart collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteSmartCollection' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/smart_collections/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete a smart collection',
            'parameters'       => [
                'id' => [
                    'description' => 'Smart collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * THEME RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/theme
         * --------------------------------------------------------------------------------
         */

        'GetThemes' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/themes.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of themes',
            'data'                 => ['root_key' => 'themes'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetTheme' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/themes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific theme',
            'data'             => ['root_key' => 'theme'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateTheme' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/themes.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new theme',
            'data'             => ['root_key' => 'theme'],
            'parameters'       => [
                'name' => [
                    'description' => 'Name of the theme',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'src' => [
                    'description' => 'Zip source for the theme',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateTheme' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/themes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing theme',
            'data'             => ['root_key' => 'theme'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific theme ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'name' => [
                    'description' => 'Name of the theme',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteTheme' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/themes/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing theme',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific theme ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PRICE RULE RELATED METHODS
         *
         * DOC: https://help.shopify.com/en/api/reference/discounts/pricerule
         * --------------------------------------------------------------------------------
         */

        'GetPriceRules' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/price_rules.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of price rules',
            'data'                 => ['root_key' => 'price_rules'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetPriceRule' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/price_rules/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific price rule',
            'data'             => ['root_key' => 'price_rule'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreatePriceRule' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/price_rules.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new price rule',
            'data'             => ['root_key' => 'price_rule'],
            'parameters'       => [
                'title' => [
                    'description' => 'Price rule title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'target_type' => [
                    'description' => 'Price rule target type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['line_item', 'shipping_line'],
                ],
                'target_selection' => [
                    'description' => 'Price rule target selection',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['all', 'entitled'],
                ],
                'value_type' => [
                    'description' => 'Price rule value type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['fixed_amount', 'percentage'],
                ],
                'value' => [
                    'description' => 'Price rule value',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => true,
                ],
                'allocation_method' => [
                    'description' => 'Price rule allocation method',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['each', 'across']
                ],
                'starts_at' => [
                    'description' => 'Price rule starts at date',
                    'location'    => 'json',
                    'type'        => 'string',
                    'format'      => 'date-time',
                    'required'    => true
                ],
                'customer_selection' => [
                    'description' => 'Price rule customer selection',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['all', 'prerequisite']
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdatePriceRule' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/price_rules/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing price rule code',
            'data'             => ['root_key' => 'price_rule'],
            'parameters'       => [
                'id' => [
                    'description' => 'Price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeletePriceRule' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/price_rules/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing price rule',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific price rule ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PRODUCT VARIANT RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/product_variant
         * --------------------------------------------------------------------------------
         */

        'GetProductVariants' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{product_id}/variants.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Get all variants for the given product',
            'data'             => ['root_key' => 'variants'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Specific product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductVariantCount' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/products/{product_id}/variants/count.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve the number of variants for a given product',
            'parameters'       => [
                'product_id' => [
                    'description' => 'Specific product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductVariant' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/variants/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific variant',
            'data'             => ['root_key' => 'variant'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific variant ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetProductVariantMetafields' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/variants/{id}/metafields.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of metafields for a variant',
            'data'          => ['root_key' => 'metafields'],
            'parameters'    => [
                'id' => [
                    'description' => 'Specific variant ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateProductVariant' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/products/{product_id}/variants.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new variant',
            'data'             => ['root_key' => 'variant'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Specific product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateProductVariant' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/variants/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing variant',
            'data'             => ['root_key' => 'variant'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific variant ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteProductVariant' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/products/{product_id}/variants/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing variant for the given product',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific variant ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'product_id' => [
                    'description' => 'Specific product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * REDIRECT RELATED METHODS
         *
         * DOC: https://help.shopify.com/api/reference/redirect
         * --------------------------------------------------------------------------------
         */

        'GetRedirects' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/redirects.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of redirects',
            'data'                 => ['root_key' => 'redirects'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetRedirectCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/redirects/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of redirects',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetRedirect' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/redirects/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific redirect',
            'data'             => ['root_key' => 'redirect'],
            'parameters'       => [
                'id' => [
                    'description' => 'Redirect ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateRedirect' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/redirects.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a redirect',
            'data'             => ['root_key' => 'redirect'],
            'parameters'       => [
                'path' => [
                    'description' => 'Path URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'target' => [
                    'description' => 'Target URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ]
        ],

        'UpdateRedirect' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/redirects/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing redirect',
            'data'             => ['root_key' => 'redirect'],
            'parameters'       => [
                'path' => [
                    'description' => 'Path URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'target' => [
                    'description' => 'Target URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ]
        ],

        'DeleteRedirect' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/redirects/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing redirect',
            'parameters'       => [
                'id' => [
                    'description' => 'Redirect ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * SCRIPT TAGS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/scripttag
         * --------------------------------------------------------------------------------
         */

        'GetScriptTags' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/script_tags.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of installed script tags',
            'data'                 => ['root_key' => 'script_tags'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetScriptTagCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/script_tags/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of script tags',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetScriptTag' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/script_tags/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a single script tag',
            'data'             => ['root_key' => 'script_tag'],
            'parameters'       => [
                'id' => [
                    'description' => 'Script tag ID to retrieve',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateScriptTag' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/script_tags.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new script tags',
            'data'             => ['root_key' => 'script_tags'],
            'parameters'       => [
                'event' => [
                    'description' => 'Event value when the script tag is loaded',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['onload'],
                ],
                'src' => [
                    'description' => 'URL of the script tag',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateScriptTag' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/script_tags/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing script tag',
            'data'             => ['root_key' => 'script_tag'],
            'parameters'       => [
                'id' => [
                    'description' => 'Script tag ID to update',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'event' => [
                    'description' => 'Event value when the script tag is loaded',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['onload'],
                ],
                'src' => [
                    'description' => 'URL of the script tag',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteScriptTag' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/script_tags/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing script tag',
            'parameters'       => [
                'id' => [
                    'description' => 'Script tag ID to delete',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * TRANSACTION RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/transaction
         * --------------------------------------------------------------------------------
         */

        'GetTransactions' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/orders/{order_id}/transactions.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a list of transactions for a given order',
            'data'          => ['root_key' => 'transactions'],
            'parameters'    => [
                'order_id' => [
                    'description' => 'Order from which we need to extract transactions',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetTransactionCount' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/orders/{order_id}/transactions/count.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve the number of script tags',
            'parameters'    => [
                'order_id' => [
                    'description' => 'Order from which we need to count transactions',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetTransaction' => [
            'httpMethod'    => 'GET',
            'uri'           => 'admin/orders/{order_id}/transactions/{id}.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Retrieve a specific transaction',
            'data'          => ['root_key' => 'transaction'],
            'parameters'    => [
                'order_id' => [
                    'description' => 'Order from which we need to extract transactions',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'id' => [
                    'description' => 'Transaction ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateTransaction' => [
            'httpMethod'    => 'POST',
            'uri'           => 'admin/orders/{order_id}/transactions.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Create a new transaction for a given order',
            'data'          => ['root_key' => 'transaction'],
            'parameters'    => [
                'order_id' => [
                    'description' => 'Order from which we need to extract transactions',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'kind' => [
                    'description' => 'The kind of transaction',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['authorization', 'capture', 'sale', 'void', 'refund'],
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        /**
         * --------------------------------------------------------------------------------
         * USAGE CHARGES RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/usagecharge
         * --------------------------------------------------------------------------------
         */

        'GetUsageCharges' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/recurring_application_charges/{recurring_charge_id}/usage_charges.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a list of usage charges for the given recurring application charges',
            'data'             => ['root_key' => 'usage_charges'],
            'parameters'       => [
                'recurring_charge_id' => [
                    'description' => 'Recurring charge from which we need to extract usage charges',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetUsageCharge' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/recurring_application_charges/{recurring_charge_id}/usage_charges/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific usage charge',
            'data'             => ['root_key' => 'usage_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific usage charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'recurring_charge_id' => [
                    'description' => 'Recurring charge from which we need to extract usage charges',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateUsageCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/recurring_application_charges/{recurring_charge_id}/usage_charges.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new usage charge',
            'data'             => ['root_key' => 'usage_charge'],
            'parameters'       => [
                'recurring_charge_id' => [
                    'description' => 'Recurring charge from which we need to extract usage charges',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'description' => [
                    'description' => 'Usage charge description',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'price' => [
                    'description' => 'Price to charge',
                    'location'    => 'json',
                    'type'        => 'number',
                    'required'    => true
                ],
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * WEBHOOK RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/webhook
         * --------------------------------------------------------------------------------
         */

        'GetWebhooks' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/webhooks.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve a list of webhooks',
            'data'                 => ['root_key' => 'webhooks'],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetWebhookCount' => [
            'httpMethod'           => 'GET',
            'uri'                  => 'admin/webhooks/count.json',
            'responseModel'        => 'GenericModel',
            'summary'              => 'Retrieve the number of webhooks',
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'GetWebhook' => [
            'httpMethod'       => 'GET',
            'uri'              => 'admin/webhooks/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Retrieve a specific webhook',
            'data'             => ['root_key' => 'webhook'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],

        'CreateWebhook' => [
            'httpMethod'       => 'POST',
            'uri'              => 'admin/webhooks.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Create a new webhook',
            'data'             => ['root_key' => 'webhook'],
            'parameters'       => [
                'format' => [
                    'description' => 'Type of data to return',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['json', 'xml']
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'topic' => [
                    'description' => 'List of webhook topic',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => [
                        'carts/create', 'carts/update', 'checkouts/create', 'checkouts/update', 'checkouts/delete', 'collections/create', 'collections/update',
                        'collections/delete', 'collection_listings/add', 'collection_listings/remove', 'collection_listings/update', 'customers/create',
                        'customers/enable', 'customers/disable', 'customers/update', 'customers/delete', 'customer_groups/create', 'customer_groups/update',
                        'customer_groups/delete', 'draft_orders/create', 'draft_orders/update', 'draft_orders/delete', 'fulfillments/create', 'fulfillments/update',
                        'fulfillment_events/create', 'fulfillment_events/delete', 'inventory_items/create', 'inventory_items/update', 'inventory_items/delete',
                        'inventory_levels/connect', 'inventory_levels/update', 'inventory_levels/disconnect', 'locations/create', 'locations/update',
                        'locations/delete', 'orders/cancelled', 'orders/create', 'orders/fulfilled', 'orders/paid', 'orders/partially_fulfilled',
                        'orders/updated', 'orders/delete', 'order_transactions/create', 'products/create', 'products/update', 'products/delete',
                        'product_listings/add', 'product_listings/remove', 'product_listings/update', 'refunds/create', 'app/uninstalled', 'shop/update',
                        'themes/create', 'themes/publish', 'themes/update', 'themes/delete'
                    ]
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'UpdateWebhook' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'admin/webhooks/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Update an existing webhook',
            'data'             => ['root_key' => 'webhook'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
            ],
            'additionalParameters' => [
                'location' => 'json',
            ],
        ],

        'DeleteWebhook' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'admin/webhooks/{id}.json',
            'responseModel'    => 'GenericModel',
            'summary'          => 'Delete an existing webhook',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * OTHERS
         * --------------------------------------------------------------------------------
         */

        'CreateDelegateAccessToken' => [
            'httpMethod'    => 'POST',
            'uri'           => 'admin/access_tokens/delegate.json',
            'responseModel' => 'GenericModel',
            'summary'       => 'Create a new delegate access token',
            'parameters'    => [
                'delegate_access_scope' => [
                    'description' => 'New scopes that are granted to the delegate access token',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => true,
                ],
            ],
            'additionalParameters' => [
                'location' => 'query',
            ],
        ],
    ],

    'models' => [
        'GenericModel' => [
            'type'                 => 'object',
            'additionalProperties' => [
                'location' => 'json'
            ]
        ]
    ]
];
