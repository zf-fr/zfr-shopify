<?php

namespace ZfrShopify\OAuth;

use GuzzleHttp\ClientInterface;
use ZfrShopify\Exception;
use ZfrShopify\Exception\RuntimeException;

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
     * @param  string   $apiKey
     * @param  string   $sharedSecret
     * @param  string   $shopDomain
     * @param  string[] $requiredScopes
     * @param  string   $code
     * @return string
     */
    public function exchangeCodeForToken(string $apiKey, string $sharedSecret, string $shopDomain, array $requiredScopes, string $code): string
    {
        $url = sprintf(
            'https://%s/admin/oauth/access_token',
            trim($shopDomain, '/')
        );

        $response = $this->httpClient->request('POST', $url, [
            'json' => [
                'client_id'     => $apiKey,
                'client_secret' => $sharedSecret,
                'code'          => $code
            ]
        ]);

        $data          = json_decode($response->getBody(), true);
        $grantedScopes = explode(',', $data['scope'] ?? '');
        $missingScopes = array_diff($requiredScopes, $grantedScopes);

        if (!empty($missingScopes)) {
            throw new RuntimeException(sprintf(
                'Missing authorization for: "%s"',
                implode(', ', $missingScopes)
            ));
        }

        return $data['access_token'];
    }
}
