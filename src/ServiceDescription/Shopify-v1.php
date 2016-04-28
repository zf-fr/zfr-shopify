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
                    'type'        => 'string',
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
                    'required'    => false
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
                    'required'    => false
                ],
                'summary_html' => [
                    'description' => 'HTML content for the article\'s summary',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
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
         * ASSETS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/asset
         * --------------------------------------------------------------------------------
         */

        'GetAssets' => [
            'httpMethod'       => 'GET',
            'uri'              => 'themes/{theme_id}/assets.json',
            'summary'          => 'Retrieve a list of assets for a given theme',
            'data'             => ['root_key' => 'assets'],
            'parameters'       => [
                'theme_id' => [
                    'description' => 'Theme from which we need to extract assets',
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

        'GetAsset' => [
            'httpMethod'       => 'GET',
            'uri'              => 'themes/{theme_id}/assets.json',
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
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateAsset' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'themes/{theme_id}/assets.json',
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
                'attachement' => [
                    'description' => 'Image through a base 64 encoded',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'src' => [
                    'description' => 'Image through an origin URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'value' => [
                    'description' => 'Set a Liquid file\'s value',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'UpdateAsset' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'themes/{theme_id}/assets.json',
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
                'attachement' => [
                    'description' => 'Image through a base 64 encoded',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'src' => [
                    'description' => 'Image through an origin URL',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'value' => [
                    'description' => 'Set a Liquid file\'s value',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'DeleteAsset' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'themes/{theme_id}/assets.json',
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
                    'type'        => 'string',
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
         * FULFILLMENT RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/reference/fulfillment
         * --------------------------------------------------------------------------------
         */

        'GetFulfillments' => [
            'httpMethod'       => 'GET',
            'uri'              => 'orders/{order_id}/fulfillments.json',
            'summary'          => 'Retrieve a list of fulfillments for a given order',
            'data'             => ['root_key' => 'fulfillments'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
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
                'created_at_max' => [
                    'description' => 'Max creation date of the fulfillment',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'created_at_min' => [
                    'description' => 'Min creation date of the fulfillment',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_max' => [
                    'description' => 'Max update date of the fulfillment',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'updated_at_min' => [
                    'description' => 'Min update date of the fulfillment',
                    'location'    => 'query',
                    'type'        => 'string',
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

        'GetFulfillment' => [
            'httpMethod'       => 'GET',
            'uri'              => 'orders/{order_id}/fulfillments/{id}.json',
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
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'CreateFulfillment' => [
            'httpMethod'       => 'POST',
            'uri'              => 'orders/{order_id}/fulfillments.json',
            'summary'          => 'Create a fulfillment for a given order',
            'data'             => ['root_key' => 'fulfillment'],
            'parameters'       => [
                'order_id' => [
                    'description' => 'Order from which we need to extract fulfillments',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'line_items' => [
                    'description' => 'An array of line items. Each line item can have ID and quantity',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'tracking_number' => [
                    'description' => 'Tracking number to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tracking_numbers' => [
                    'description' => 'Tracking numbers to use',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'tracking_url' => [
                    'description' => 'Tracking URL to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'tracking_company' => [
                    'description' => 'Tracking company to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'notify_customer' => [
                    'description' => 'If set to true, an email is sent to the customer',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
            ]
        ],

        'UpdateFulfillment' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'orders/{order_id}/fulfillments/{id}.json',
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
                'tracking_number' => [
                    'description' => 'Tracking number to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
            ]
        ],

        'CompleteFulfillment' => [
            'httpMethod'       => 'POST',
            'uri'              => 'orders/{order_id}/fulfillments/{id}/complete.json',
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
            'uri'              => 'orders/{order_id}/fulfillments/{id}/cancel.json',
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
         * METAFIELDS RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/metafield
         * --------------------------------------------------------------------------------
         */

        'GetMetafields' => [
            'httpMethod'       => 'GET',
            'uri'              => 'metafields.json',
            'summary'          => 'Retrieve a list of metafields',
            'data'             => ['root_key' => 'metafields'],
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
                'namespace' => [
                    'description' => 'Filter metafields by namespace',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'key' => [
                    'description' => 'Filter metafields by key',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'value_type' => [
                    'description' => 'Filter metafields by value type',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['string', 'integer']
                ],
                'metafield' => [
                    'description' => 'Filter metafields by resource type and ID (accepts sub-fields "owner_id" and "owner_resource")',
                    'location'    => 'query',
                    'type'        => 'array',
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

        'GetMetafield' => [
            'httpMethod'       => 'GET',
            'uri'              => 'metafields/{id}.json',
            'summary'          => 'Retrieve specific metafield',
            'data'             => ['root_key' => 'metafield'],
            'parameters'       => [
                'id' => [
                    'description' => 'Metafield ID',
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

        'CreateMetafield' => [
            'httpMethod'       => 'POST',
            'uri'              => 'metafields.json',
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
                'value_type' => [
                    'description' => 'Metafield value type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['string', 'integer']
                ],
                'description' => [
                    'description' => 'Optional description to use',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'UpdateMetafield' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'metafields/{id}.json',
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
                'value_type' => [
                    'description' => 'Metafield value type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['string', 'integer']
                ]
            ]
        ],

        'DeleteMetafield' => [
            'httpMethod' => 'DELETE',
            'uri'        => 'metafields/{id}.json',
            'summary'    => 'Delete specific metafield',
            'parameters' => [
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

        'GetOrder' => [
            'httpMethod'       => 'GET',
            'uri'              => 'orders/{id}.json',
            'summary'          => 'Retrieve specific order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
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

        'CloseOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'orders/{id}/close.json',
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
            'uri'              => 'orders/{id}/open.json',
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

        'CancelOrder' => [
            'httpMethod'       => 'POST',
            'uri'              => 'orders/{id}/cancel.json',
            'summary'          => 'Cancel a given order',
            'data'             => ['root_key' => 'order'],
            'parameters'       => [
                'id' => [
                    'description' => 'Order ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'restock' => [
                    'description' => 'Restock the items for this order back to your store',
                    'location'    => 'json',
                    'type'        => 'boolean',
                    'required'    => false
                ],
                'reason' => [
                    'description' => 'The reason for the order cancellation',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['customer', 'fraud', 'inventory', 'other']
                ],
                'email' => [
                    'description' => 'Send an email to the customer notifying them of the cancellation',
                    'location'    => 'json',
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
                    'type'        => 'string',
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
         * PRODUCT RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/product
         * --------------------------------------------------------------------------------
         */

        'GetProducts' => [
            'httpMethod'       => 'GET',
            'uri'              => 'products.json',
            'summary'          => 'Retrieve a list of products',
            'data'             => ['root_key' => 'products'],
            'parameters'       => [
                'ids' => [
                    'description' => 'A comma separated ids',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
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
                    'description' => 'Filter by product title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'vendor' => [
                    'description' => 'Filter by product vendor',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'handle' => [
                    'description' => 'Filter by product handle',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ],
                'collection_id' => [
                    'description' => 'Filter by collection id',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false
                ],
                'published_status' => [
                    'description' => 'Current status of the product',
                    'location'    => 'query',
                    'type'        => 'string',
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

        'GetProduct' => [
            'httpMethod'       => 'GET',
            'uri'              => 'products/{id}.json',
            'summary'          => 'Retrieve specific product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'id' => [
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

        'CreateProduct' => [
            'httpMethod'       => 'POST',
            'uri'              => 'products.json',
            'summary'          => 'Create a new product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'title' => [
                    'description' => 'Product title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => true
                ],
                'body_html' => [
                    'description' => 'Product description',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'vendor' => [
                    'description' => 'Product vendor',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'product_type' => [
                    'description' => 'Product type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'images' => [
                    'description' => 'List of images. Each element can either contain all the attributes accepted by a product image',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'tags' => [
                    'description' => 'List of tags separated by comma',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'variants' => [
                    'description' => 'List of variants. Each element can either contain all the attributes accepted by a product variant',
                    'location'    => 'json',
                    'type'        => 'array',
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

        'UpdateProduct' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'products/{id}.json',
            'summary'          => 'Update an existing product',
            'data'             => ['root_key' => 'product'],
            'parameters'       => [
                'id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Product title',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'body_html' => [
                    'description' => 'Product description',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'vendor' => [
                    'description' => 'Product vendor',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'product_type' => [
                    'description' => 'Product type',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'images' => [
                    'description' => 'List of images. Each element can either contain all the attributes accepted by a product image',
                    'location'    => 'json',
                    'type'        => 'array',
                    'required'    => false
                ],
                'tags' => [
                    'description' => 'List of tags separated by comma',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false
                ],
                'variants' => [
                    'description' => 'List of variants. Each element can either contain all the attributes accepted by a product variant',
                    'location'    => 'json',
                    'type'        => 'array',
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

        'DeleteProduct' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'products/{id}.json',
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
         * THEME RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/theme
         * --------------------------------------------------------------------------------
         */

        'GetThemes' => [
            'httpMethod'       => 'GET',
            'uri'              => 'themes.json',
            'summary'          => 'Retrieve a list of themes',
            'data'             => ['root_key' => 'themes'],
            'parameters'       => [
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
                ]
            ]
        ],

        'GetTheme' => [
            'httpMethod'       => 'GET',
            'uri'              => 'themes/{id}.json',
            'summary'          => 'Retrieve a specific theme',
            'data'             => ['root_key' => 'theme'],
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

        'CreateTheme' => [
            'httpMethod'       => 'POST',
            'uri'              => 'themes.json',
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
                'role' => [
                    'description' => 'Theme role name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['main', 'mobile', 'unpublished']
                ]
            ]
        ],

        'UpdateTheme' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'webhooks/{id}.json',
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
                'role' => [
                    'description' => 'Theme role name',
                    'location'    => 'json',
                    'type'        => 'string',
                    'required'    => false,
                    'enum'        => ['main', 'mobile', 'unpublished']
                ]
            ]
        ],

        'DeleteTheme' => [
            'httpMethod'       => 'DELETE',
            'uri'              => 'themes/{id}.json',
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
    ]
];
