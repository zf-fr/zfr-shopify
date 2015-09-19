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
         * SHOP RELATED METHODS
         *
         * DOC: https://docs.shopify.com/api/shop
         * --------------------------------------------------------------------------------
         */

        'GetShop' => [
            'httpMethod'       => 'GET',
            'uri'              => '/shop.json',
            'summary'          => 'Get data about a single shop',
            'parameters'       => [
                'access_token' => [
                    'description' => 'Access token needed to do any Shopify request',
                    'location'    => 'header',
                    'sentAs'      => 'X-Shopify-Access-Token',
                    'required'    => true
                ],
            ]
        ],
    ]
];
