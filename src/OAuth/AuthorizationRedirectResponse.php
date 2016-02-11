<?php

namespace ZfrShopify\OAuth;

use Zend\Diactoros\Response\RedirectResponse;

/**
 * Create a redirection response to Shopify
 *
 * @author Michaël Gallego
 */
class AuthorizationRedirectResponse extends RedirectResponse
{
    /**
     * @param string $apiKey
     * @param string $shopDomain
     * @param array  $scopes
     * @param string $redirectUri
     * @param string $nonce
     */
    public function __construct(string $apiKey, string $shopDomain, array $scopes, string $redirectUri, string $nonce)
    {
        $uri = sprintf(
            'https://%s.myshopify.com/admin/oauth/authorize?client_id=%s&scope=%s&redirect_uri=%s&state=%s',
            str_replace('.myshopify.com', '', $shopDomain),
            $apiKey,
            implode(',', $scopes),
            $redirectUri,
            $nonce
        );

        parent::__construct($uri);
    }
}
