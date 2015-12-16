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
    'baseUrl'     => 'https://{shop}.myshopify.com/admin',
    'description' => 'Shopify is an awesome e-commerce platform',
    'operations'  => [
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
            'summary'          => 'Retrieve a list of webhooks',
            'parameters'       => [
                'id' => [
                    'description' => 'Specific webhook ID',
                    'location'    => 'uri',
                    'type'        => 'string',
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
                    'enum'        => ['json', 'xml']
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => true
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
                    ]
                ],
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
                    'type'        => 'string',
                    'required'    => false
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
                    'type'        => 'string',
                    'required'    => true
                ],
                'address' => [
                    'description' => 'Specific URL for the webhook',
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
                'fields' => [
                    'description' => 'Comma separated list of fields to retrieve',
                    'location'    => 'query',
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
                    'type'        => 'string',
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

        'GetAccessToken' => [
            'httpMethod'       => 'POST',
            'uri'              => 'oauth/access_token',
            'summary'          => 'Get data about a single shop',
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
