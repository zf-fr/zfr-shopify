<?php

namespace ZfrShopify\OAuth;

use GuzzleHttp\Client as HttpClient;
use ZfrShopify\Exception;

/**
 * Simplify the OAuth dance of Shopify
 *
 * Especially, this class can be used to create an authorization response, and exchanging a temporary code
 * against a long-lived access token
 *
 * @author Michaël Gallego
 */
class Authorizer
{
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

        $client = new HttpClient();
        $result = $client->post($url, [
            'json' => [
                'client_id'     => $apiKey,
                'client_secret' => $sharedSecret,
                'code'          => $code
            ]
        ]);

        return json_decode($result->getBody(), true)['access_token'];
    }
}