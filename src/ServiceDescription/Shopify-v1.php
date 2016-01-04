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
         * ARTICLE RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/article
         * --------------------------------------------------------------------------------
         */

        'GetArticles' => [
            'httpMethod'       => 'GET',
            'uri'              => 'blogs/{blog_id}/articles.json',
            'summary'          => 'Retrieve a list of articles for a given blog',
            'data'             => ['root_key' => 'articles'],
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'created_at_max' => [
                    'description' => 'Max creation date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_max' => [
                    'description' => 'Max update date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_min' => [
                    'description' => 'Min update date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_max' => [
                    'description' => 'Max publication date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_min' => [
                    'description' => 'Min publication date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'title' => [
                    'description' => 'Filter by page title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'handle' => [
                    'description' => 'Filter by page handle',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_status' => [
                    'description' => 'Current status of the article',
                    'location'    => 'query',
                    'type'        => 'enum',
                    'required'    => false,
                    'enum'        => ['published', 'unpublished', 'any']
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetArticle' => [
            'httpMethod'       => 'GET',
            'uri'              => 'blogs/{blog_id}/articles/{id}.json',
            'summary'          => 'Retrieve specific article',
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
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetArticlesAuthors' => [
            'httpMethod' => 'GET',
            'uri'        => 'articles/authors.json',
            'summary'    => 'Retrieve list of all article authors',
            'data'       => ['root_key' => 'authors'],
        ],

        'GetArticlesTags' => [
            'httpMethod'       => 'GET',
            'uri'              => 'blogs/{blog_id}/articles/tags.json',
            'summary'          => 'Retrieve all tags for a given blog',
            'data'             => ['root_key' => 'tags'],
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'popular' => [
                    'description' => 'A flag to inidicate only to a certain number of the most popular tags',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ]
            ]
        ],

        'CreateArticle' => [
            'httpMethod'       => 'POST',
            'uri'              => 'blogs/{blog_id}/articles.json',
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
                'author' => [
                    'description' => 'Author for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tags' => [
                    'description' => 'Tags for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'HTML content for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'summary_html' => [
                    'description' => 'HTML content for the article\'s summary',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'handle' => [
                    'description' => 'Handle for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'published_at' => [
                    'description' => 'Publication date for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'image' => [
                    'description' => 'Set the image (either through a base 64 attachment or URL)',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'UpdateArticle' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'blogs/{blog_id}/articles/{id}.json',
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
                'title' => [
                    'description' => 'Article title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'author' => [
                    'description' => 'Author for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tags' => [
                    'description' => 'Tags for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'HTML content for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'summary_html' => [
                    'description' => 'HTML content for the article\'s summary',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'handle' => [
                    'description' => 'Handle for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'published_at' => [
                    'description' => 'Publication date for the article',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'image' => [
                    'description' => 'Set the image (either through a base 64 attachment or URL)',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'DeleteArticle' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'blogs/{blog_id}/articles/{id}.json',
            'summary'          => 'Delete an existing article',
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
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
         * CUSTOM COLLECTION RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/customcollection
         * --------------------------------------------------------------------------------
         */

        'GetCustomCollections' => [
            'httpMethod'       => 'GET',
            'uri'              => 'custom_collections.json',
            'summary'          => 'Retrieve a list of custom collections',
            'data'             => ['root_key' => 'custom_collections'],
            'parameters'       => [
                'title' => [
                    'description' => 'Only show custom collections with given title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'handle' => [
                    'description' => 'Filter by collection handle',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'product_id' => [
                    'description' => 'Show custom collections that includes given product',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'created_at_max' => [
                    'description' => 'Max creation date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_max' => [
                    'description' => 'Max update date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_min' => [
                    'description' => 'Min update date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_max' => [
                    'description' => 'Max publication date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_min' => [
                    'description' => 'Min publication date of the custom collection',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_status' => [
                    'description' => 'Current status of the page',
                    'location'    => 'query',
                    'type'        => 'enum',
                    'required'    => false,
                    'enum'        => ['published', 'unpublished', 'any']
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetCustomCollection' => [
            'httpMethod'       => 'GET',
            'uri'              => 'custom_collections/{id}.json',
            'summary'          => 'Retrieve specific custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Custom collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateCustomCollection' => [
            'httpMethod'       => 'POST',
            'uri'              => 'custom_collections.json',
            'summary'          => 'Create a custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'title' => [
                    'description' => 'Custom collection title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'Collection description',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published' => [
                    'description' => 'Status for the custom collection',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'image' => [
                    'description' => 'Attached image (can accept a "src" or "attachment" sub-parameter)',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'collects' => [
                    'description' => 'Collect with list of product',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'UpdateCustomCollection' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'custom_collections/{id}.json',
            'summary'          => 'Update a custom collection',
            'data'             => ['root_key' => 'custom_collection'],
            'parameters'       => [
                'id' => [
                    'description' => 'Custom collection ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Custom collection title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'Collection description',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published' => [
                    'description' => 'Status for the custom collection',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'image' => [
                    'description' => 'Attached image (can accept a "src" or "attachment" sub-parameter)',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'collects' => [
                    'description' => 'Collect with list of product',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'DeleteCustomCollection' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'custom_collections/{id}.json',
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
         * EVENTS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/events
         * --------------------------------------------------------------------------------
         */

        'GetEvents' => [
            'httpMethod'       => 'GET',
            'uri'              => 'events.json',
            'summary'          => 'Retrieve a list of events',
            'data'             => ['root_key' => 'events'],
            'parameters'       => [
                'filter' => [
                    'description' => 'Only show events specified in filter',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'verb' => [
                    'description' => 'Only show events specified of a certain kind',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_max' => [
                    'description' => 'Max creation date of the event',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the event',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetEvent' => [
            'httpMethod'       => 'GET',
            'uri'              => 'events/{id}.json',
            'summary'          => 'Retrieve specific event',
            'data'             => ['root_key' => 'event'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
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
            'httpMethod'       => 'GET',
            'uri'              => 'orders.json',
            'summary'          => 'Retrieve a list of orders',
            'data'             => ['root_key' => 'orders'],
            'parameters'       => [
                'ids' => [
                    'description' => 'Comma separated list of orders',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'status' => [
                    'description' => 'Status of the order',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['open', 'closed', 'cancelled', 'any']
                ],
                'financial_status' => [
                    'description' => 'Financial status of the order',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => [
                        'authorized', 'pending', 'paid', 'partially_paid',
                        'refunded', 'voided', 'partially_refunded', 'any', 'unpaid'
                    ]
                ],
                'fulfillment_status' => [
                    'description' => 'Fulfillment status of the order',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['shipped', 'partial', 'unshipped', 'any']
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        /**
         * --------------------------------------------------------------------------------
         * PAGE RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/page
         * --------------------------------------------------------------------------------
         */

        'GetPages' => [
            'httpMethod'       => 'GET',
            'uri'              => 'pages.json',
            'summary'          => 'Retrieve a list of pages',
            'data'             => ['root_key' => 'pages'],
            'parameters'       => [
                'created_at_max' => [
                    'description' => 'Max creation date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_max' => [
                    'description' => 'Max update date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_min' => [
                    'description' => 'Min update date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_max' => [
                    'description' => 'Max publication date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_at_min' => [
                    'description' => 'Min publication date of the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'title' => [
                    'description' => 'Filter by page title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'handle' => [
                    'description' => 'Filter by page handle',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published_status' => [
                    'description' => 'Current status of the page',
                    'location'    => 'query',
                    'type'        => 'enum',
                    'required'    => false,
                    'enum'        => ['published', 'unpublished', 'any']
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetPage' => [
            'httpMethod'       => 'GET',
            'uri'              => 'pages/{id}.json',
            'summary'          => 'Retrieve specific page',
            'data'             => ['root_key' => 'page'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreatePage' => [
            'httpMethod'       => 'POST',
            'uri'              => 'pages.json',
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
                'handle' => [
                    'description' => 'Handle for the page',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'UpdatePage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'pages/{id}.json',
            'summary'          => 'Update an existing page',
            'data'             => ['root_key' => 'page'],
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Page title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'handle' => [
                    'description' => 'Handle for the page',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'HTML content for the page',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'DeletePage' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'pages/{id}.json',
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
         * PRODUCT IMAGES RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/product_image
         * --------------------------------------------------------------------------------
         */

        'GetProductImages' => [
            'httpMethod'       => 'GET',
            'uri'              => 'products/{product_id}/images.json',
            'summary'          => 'Retrieve a list of product images',
            'data'             => ['root_key' => 'images'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetProductImage' => [
            'httpMethod'       => 'GET',
            'uri'              => 'products/{product_id}/images/{id}.json',
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
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateProductImage' => [
            'httpMethod'       => 'POST',
            'uri'              => 'products/{product_id}/images.json',
            'summary'          => 'Create a new product image',
            'data'             => ['root_key' => 'image'],
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'variant_ids' => [
                    'description' => 'Variant ids attached to this image',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'attachment' => [
                    'description' => 'Base 64 encoded of the image',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'src' => [
                    'description' => 'Source URL that will be downloaded by Shopify',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'filename' => [
                    'description' => 'Name of the file to upload',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'position' => [
                    'description' => 'Position of the image for the product',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'UpdateProductImage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'products/{product_id}/images/{id}.json',
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
                'variant_ids' => [
                    'description' => 'Variant ids attached to this image',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'attachment' => [
                    'description' => 'Base 64 encoded of the image',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'src' => [
                    'description' => 'Source URL that will be downloaded by Shopify',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'filename' => [
                    'description' => 'Name of the file to upload',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'position' => [
                    'description' => 'Position of the image for the product',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'DeleteProductImage' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'products/{product_id}/images/{id}.json',
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
            'httpMethod'       => 'GET',
            'uri'              => 'recurring_application_charges.json',
            'summary'          => 'Retrieve a list of recurring application charges',
            'data'             => ['root_key' => 'recurring_application_charges'],
            'parameters'       => [
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetRecurringApplicationCharge' => [
            'httpMethod'       => 'GET',
            'uri'              => 'recurring_application_charges/{id}.json',
            'summary'          => 'Retrieve a specific recurring application charge',
            'data'             => ['root_key' => 'recurring_application_charge'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific recurring application charge ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateRecurringApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'recurring_application_charges.json',
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
                'test' => [
                    'description' => 'Test mode for the charge',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'trial_days' => [
                    'description' => 'Number of days for allowing trial',
                    'location'    => 'json',
                    'type'        => 'integer',
                    'required'    => false
                ]
            ]
        ],

        'ActivateRecurringApplicationCharge' => [
            'httpMethod'       => 'POST',
            'uri'              => 'recurring_application_charges/{id}/activate.json',
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
            'uri'              => 'recurring_application_charges/{id}.json',
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
         * SHOP RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/shop
         * --------------------------------------------------------------------------------
         */

        'GetShop' => [
            'httpMethod'       => 'GET',
            'uri'              => 'shop.json',
            'summary'          => 'Get data about a single shop',
            'data'             => ['root_key' => 'shop'],
            'parameters'       => []
        ],

        /**
         * --------------------------------------------------------------------------------
         * WEBHOOK RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/webhook
         * --------------------------------------------------------------------------------
         */

        'GetWebhooks' => [
            'httpMethod'       => 'GET',
            'uri'              => 'webhooks.json',
            'summary'          => 'Retrieve a list of webhooks',
            'data'             => ['root_key' => 'webhooks'],
            'parameters'       => [
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_max' => [
                    'description' => 'Max creation date of the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_max' => [
                    'description' => 'Max update date of the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_min' => [
                    'description' => 'Min update date of the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'topic' => [
                    'description' => 'List of webhook topic',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => [
                        'orders/create', 'orders/delete', 'orders/updated', 'orders/paid', 'orders/cancelled', 'orders/fulfilled', 'orders/partially_fulfilled',
                        'order_transactions/create', 'carts/create', 'carts/update', 'checkouts/create', 'checkouts/update', 'checkouts/delete', 'refunds/create',
                        'products/create', 'products/update', 'products/delete', 'collections/create', 'collections/update', 'collections/delete',
                        'customer_groups/create', 'customer_groups/update', 'customer_groups/delete', 'customers/create', 'customers/enable', 'customers/disable',
                        'customers/update', 'customers/delete', 'fulfillments/create', 'fulfillments/update', 'shop/update', 'disputes/create', 'disputes/update',
                        'app/uninstalled'
                    ]
                ],
                'limit' => [
                    'description' => 'A limit of results to fetch',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'max'         => 250,
                    'required'    => false
                ],
                'page' => [
                    'description' => 'Page to show',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'min'         => 1,
                    'required'    => false
                ],
                'since_id' => [
                    'description' => 'Restrict results after the specified id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetWebhook' => [
            'httpMethod'       => 'GET',
            'uri'              => 'webhooks/{id}.json',
            'summary'          => 'Retrieve a specific webhook',
            'data'             => ['root_key' => 'webhook'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateWebhook' => [
            'httpMethod'       => 'POST',
            'uri'              => 'webhooks.json',
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
                        'orders/create', 'orders/delete', 'orders/updated', 'orders/paid', 'orders/cancelled', 'orders/fulfilled', 'orders/partially_fulfilled',
                        'order_transactions/create', 'carts/create', 'carts/update', 'checkouts/create', 'checkouts/update', 'checkouts/delete', 'refunds/create',
                        'products/create', 'products/update', 'products/delete', 'collections/create', 'collections/update', 'collections/delete',
                        'customer_groups/create', 'customer_groups/update', 'customer_groups/delete', 'customers/create', 'customers/enable', 'customers/disable',
                        'customers/update', 'customers/delete', 'fulfillments/create', 'fulfillments/update', 'shop/update', 'disputes/create', 'disputes/update',
                        'app/uninstalled'
                    ]
                ],
                'fields' => [
                    'description' => 'List of fields return by the webhooks',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ]
            ]
        ],

        'UpdateWebhook' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'webhooks/{id}.json',
            'summary'          => 'Update an existing webhook',
            'data'             => ['root_key' => 'webhook'],
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'topic' => [
                    'description' => 'List of webhook topic',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => [
                        'orders/create', 'orders/delete', 'orders/updated', 'orders/paid', 'orders/cancelled', 'orders/fulfilled', 'orders/partially_fulfilled',
                        'order_transactions/create', 'carts/create', 'carts/update', 'checkouts/create', 'checkouts/update', 'checkouts/delete', 'refunds/create',
                        'products/create', 'products/update', 'products/delete', 'collections/create', 'collections/update', 'collections/delete',
                        'customer_groups/create', 'customer_groups/update', 'customer_groups/delete', 'customers/create', 'customers/enable', 'customers/disable',
                        'customers/update', 'customers/delete', 'fulfillments/create', 'fulfillments/update', 'shop/update', 'disputes/create', 'disputes/update',
                        'app/uninstalled'
                    ]
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'DeleteWebhook' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'webhooks/{id}.json',
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
         * OAUTH RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/authentication/oauth#confirming-installation
         * --------------------------------------------------------------------------------
         */

        'ExchangeCodeForToken' => [
            'httpMethod'       => 'POST',
            'uri'              => 'oauth/access_token',
            'summary'          => 'Code an OAuth code to a long-lived access token',
            'parameters'       => [
                'client_id' => [
                    'description' => 'API key of the app',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'client_secret' => [
                    'description' => 'Shared secret of the app',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'code' => [
                    'description' => 'Authorization code',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ]
            ]
        ],
    ]
];
