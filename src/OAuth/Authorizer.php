<?php

namespace ZfrShopify\OAuth;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\RedirectResponse;
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
     * Create an authorization redirection request for a given app
     *
     * Please note that this method will automatically generate a nonce value. You are responsible to
     * persist it in database, and validate it during the OAuth dance
     *
     * @param  string $apiKey
     * @param  string $shopDomain
     * @param  array  $scopes
     * @param  string $redirectionUri
     * @param  string $nonce
     * @return ResponseInterface
     * @throws Exception\MissingApiKeyException
     */
    public function createAuthorizationResponse(string $apiKey, string $shopDomain, array $scopes, string $redirectionUri, string $nonce)
    {
        $uri = sprintf(
            'https://%s.myshopify.com/admin/oauth/authorize?client_id=%s&scope=%s&redirect_uri=%s&state=%s',
            str_replace('.myshopify.com', '', $shopDomain),
            $apiKey,
            implode(',', $scopes),
            $redirectionUri,
            $nonce
        );

        return new RedirectResponse($uri);
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