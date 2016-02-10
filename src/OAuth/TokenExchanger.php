<?php

namespace ZfrShopify\OAuth;

use GuzzleHttp\ClientInterface;
use ZfrShopify\Exception;

/**
 * @author Michaël Gallego
 */
class TokenExchanger
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Exchange a temporary token for a long lived access token
     *
     * @param  string $apiKey
     * @param  string $sharedSecret
     * @param  string $shopDomain
     * @param  string $code
     * @return string
     */
    public function exchangeCodeForToken(string $apiKey, string $sharedSecret, string $shopDomain, string $code): string
    {
        $url = sprintf(
            'https://%s/admin/oauth/access_token',
            trim($shopDomain, '/')
        );

        $result = $this->httpClient->request('POST', $url, [
            'json' => [
                'client_id'     => $apiKey,
                'client_secret' => $sharedSecret,
                'code'          => $code
            ]
        ]);

        return json_decode($result->getBody(), true)['access_token'];
    }
}