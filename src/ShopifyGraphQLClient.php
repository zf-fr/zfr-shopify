<?php

namespace ZfrShopify;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use ZfrShopify\Exception\GraphQLErrorException;
use ZfrShopify\Exception\GraphQLUserErrorException;
use ZfrShopify\Exception\RuntimeException;

/**
 * This minimal class allows to interact with the new GraphQL Admin API. It allows to do
 * both queries and mutations. Its implementation is pretty minimal, and let you the flexibility to write
 * your own request.
 *
 * @author Michaël Gallego
 */
class ShopifyGraphQLClient
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    /**
     * @var array
     */
    private $connectionOptions;

    /**
     * @param array                $connectionOptions
     * @param ClientInterface|null $guzzleClient
     */
    public function __construct(array $connectionOptions, ClientInterface $guzzleClient = null)
    {
        $this->validateConnectionOptions($connectionOptions);
        $this->connectionOptions = $connectionOptions;

        $this->guzzleClient = $guzzleClient ?? $this->createDefaultClient();
    }

    /**
     * Validate all the connection parameters
     *
     * @param array $connectionOptions
     */
    private function validateConnectionOptions(array $connectionOptions)
    {
        if (!isset($connectionOptions['shop'], $connectionOptions['version'], $connectionOptions['private_app'])) {
            throw new RuntimeException(
                '"shop", "version" and "private_app" must be provided when instantiating the Shopify client'
            );
        }

        if ($connectionOptions['private_app'] && !isset($connectionOptions['password'])) {
            throw new RuntimeException(
                'You must specify the "password" option when instantiating the Shopify client for a private app'
            );
        }

        if (!$connectionOptions['private_app'] && !isset($connectionOptions['access_token'])) {
            throw new RuntimeException(
                'You must specify the "access_token" option when instantiating the Shopify client for a public app'
            );
        }
    }

    /**
     * @return ClientInterface
     */
    private function createDefaultClient(): ClientInterface
    {
        $baseUri = 'https://' . str_replace('.myshopify.com', '', $this->connectionOptions['shop']) . '.myshopify.com';

        $handlerStack = HandlerStack::create(new CurlHandler());

        $httpClient = new Client([
            'base_uri' => $baseUri,
            'handler'  => $handlerStack,
            'headers'  => [
                'Content-Type'           => 'application/json',
                'X-Shopify-Access-Token' => ($this->connectionOptions['private_app']
                    ? $this->connectionOptions['password']
                    : $this->connectionOptions['access_token']
                ),
            ]
        ]);

        return $httpClient;
    }

    /**
     * Create a GraphQL request
     *
     * @param  string $query
     * @param  array  $variables
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $query, array $variables = []): array
    {
        $url = sprintf('admin/api/%s/graphql.json', $this->connectionOptions['version']);

        $response = $this->guzzleClient->request('POST', $url, [
            'body' => json_encode([
                'query'     => $query,
                'variables' => $variables ? $variables : null
            ])
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        // Shopify GraphQL API always returns 200, even in case of errors. We therefore inspect the result of the
        // request and check if there are any errors

        if (isset($result['errors'])) {
            throw new GraphQLErrorException($result['errors']);
        }

        // We also check for "userErrors" (this requires that they are part of the request though) to throw a
        // specific exception
        
        if(is_iterable(current($result['data']))) {
            foreach (current($result['data']) as $key => $value) {
                if ($key === 'userErrors' && !empty($value)) {
                    throw new GraphQLUserErrorException($value);
                }
            }
        }

        return $result['data'];
    }
}
