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

        'GetPages' => [
            'httpMethod'       => 'GET',
            'uri'              => 'blogs/{blog_id}/articles.json',
            'summary'          => 'Retrieve a list of articles for a given blog',
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

        'GetArticle' => [
            'httpMethod'       => 'GET',
            'uri'              => 'blogs/{blog_id}/articles/{id}.json',
            'summary'          => 'Retrieve specific article',
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

        'CreateArticle' => [
            'httpMethod'       => 'POST',
            'uri'              => 'blogs/{blog_id}/articles.json',
            'summary'          => 'Create a new article',
            'parameters'       => [
                'blog_id' => [
                    'description' => 'Blog from which we need to extract articles',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Article title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[title]'
                ],
                'author' => [
                    'description' => 'Author for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[author]'
                ],
                'tags' => [
                    'description' => 'Tags for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[tags]'
                ],
                'body_html' => [
                    'description' => 'HTML content for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[body_html]'
                ],
                'summary_html' => [
                    'description' => 'HTML content for the article\'s summary',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[summary_html]'
                ],
                'handle' => [
                    'description' => 'Handle for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[handle]'
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                    'sentAs'      => 'article[published]'
                ],
                'published_at' => [
                    'description' => 'Publication date for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[published_at]'
                ],
                'image' => [
                    'description' => 'Set the image (either through a base 64 attachment or URL)',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'article[image]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'article[metafields]'
                ]
            ]
        ],

        'UpdateArticle' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'blogs/{blog_id}/articles/{id}.json',
            'summary'          => 'Update an existing article',
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
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[title]'
                ],
                'author' => [
                    'description' => 'Author for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[author]'
                ],
                'tags' => [
                    'description' => 'Tags for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[tags]'
                ],
                'body_html' => [
                    'description' => 'HTML content for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[body_html]'
                ],
                'summary_html' => [
                    'description' => 'HTML content for the article\'s summary',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'article[summary_html]'
                ],
                'handle' => [
                    'description' => 'Handle for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[handle]'
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                    'sentAs'      => 'article[published]'
                ],
                'published_at' => [
                    'description' => 'Publication date for the article',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'article[published_at]'
                ],
                'image' => [
                    'description' => 'Set the image (either through a base 64 attachment or URL)',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'article[image]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'article[metafields]'
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
         * ORDER RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/order
         * --------------------------------------------------------------------------------
         */

        'GetOrders' => [
            'httpMethod'       => 'GET',
            'uri'              => 'orders.json',
            'summary'          => 'Retrieve a list of orders',
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
            'parameters'       => [
                'title' => [
                    'description' => 'Page title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'page[title]'
                ],
                'body_html' => [
                    'description' => 'HTML content for the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'page[body_html]'
                ],
                'handle' => [
                    'description' => 'Handle for the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'page[handle]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'page[metafields]'
                ]
            ]
        ],

        'UpdatePage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'pages/{id}.json',
            'summary'          => 'Update an existing page',
            'parameters'       => [
                'id' => [
                    'description' => 'Page ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'title' => [
                    'description' => 'Page title',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'page[title]'
                ],
                'handle' => [
                    'description' => 'Handle for the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'page[handle]'
                ],
                'body_html' => [
                    'description' => 'HTML content for the page',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'page[body_html]'
                ],
                'published' => [
                    'description' => 'Set the publication status',
                    'location'    => 'query',
                    'type'        => 'boolean',
                    'required'    => false,
                    'sentAs'      => 'page[published]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'page[metafields]'
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
            'parameters'       => [
                'product_id' => [
                    'description' => 'Product ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'variant_ids' => [
                    'description' => 'Variant ids attached to this image',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'image[variant_ids]'
                ],
                'attachment' => [
                    'description' => 'Base 64 encoded of the image',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[attachment]'
                ],
                'src' => [
                    'description' => 'Source URL that will be downloaded by Shopify',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[src]'
                ],
                'filename' => [
                    'description' => 'Name of the file to upload',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[filename]'
                ],
                'position' => [
                    'description' => 'Position of the image for the product',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                    'sentAs'      => 'image[position]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'image[metafields]'
                ]
            ]
        ],

        'UpdateProductImage' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'products/{product_id}/images/{id}.json',
            'summary'          => 'Update an existing product image',
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
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'image[variant_ids]'
                ],
                'attachment' => [
                    'description' => 'Base 64 encoded of the image',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[attachment]'
                ],
                'src' => [
                    'description' => 'Source URL that will be downloaded by Shopify',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[src]'
                ],
                'filename' => [
                    'description' => 'Name of the file to upload',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'image[filename]'
                ],
                'position' => [
                    'description' => 'Position of the image for the product',
                    'location'    => 'query',
                    'type'        => 'integer',
                    'required'    => false,
                    'sentAs'      => 'image[position]'
                ],
                'metafields' => [
                    'description' => 'Optional metafields to attach',
                    'location'    => 'query',
                    'type'        => 'array',
                    'required'    => false,
                    'sentAs'      => 'image[metafields]'
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
         * SHOP RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/shop
         * --------------------------------------------------------------------------------
         */

        'GetShop' => [
            'httpMethod'       => 'GET',
            'uri'              => 'shop.json',
            'summary'          => 'Get data about a single shop',
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
            'parameters'       => [
                'format' => [
                    'description' => 'Type of data to return',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => ['json', 'xml'],
                    'sentAs'      => 'webhook[format]'
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'sentAs'      => 'webhook[address]'
                ],
                'topic' => [
                    'description' => 'List of webhook topic',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true,
                    'enum'        => [
                        'orders/create', 'orders/delete', 'orders/updated', 'orders/paid', 'orders/cancelled', 'orders/fulfilled', 'orders/partially_fulfilled',
                        'order_transactions/create', 'carts/create', 'carts/update', 'checkouts/create', 'checkouts/update', 'checkouts/delete', 'refunds/create',
                        'products/create', 'products/update', 'products/delete', 'collections/create', 'collections/update', 'collections/delete',
                        'customer_groups/create', 'customer_groups/update', 'customer_groups/delete', 'customers/create', 'customers/enable', 'customers/disable',
                        'customers/update', 'customers/delete', 'fulfillments/create', 'fulfillments/update', 'shop/update', 'disputes/create', 'disputes/update',
                        'app/uninstalled'
                    ],
                    'sentAs'      => 'webhook[topic]'
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'webhook[fields]'
                ]
            ]
        ],

        'UpdateWebhook' => [
            'httpMethod'       => 'PUT',
            'uri'              => 'webhooks/{id}.json',
            'summary'          => 'Update an existing webhook',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'integer',
                    'required'    => true
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'webhook[address]'
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
                    ],
                    'sentAs'      => 'webhook[topic]'
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false,
                    'sentAs'      => 'webhook[fields]'
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
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'client_secret' => [
                    'description' => 'Shared secret of the app',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ],
                'code' => [
                    'description' => 'Authorization code',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
                ]
            ]
        ],
    ]
];
