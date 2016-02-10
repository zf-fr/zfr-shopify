<?php

namespace ZfrShopify\Validator;

use Psr\Http\Message\ServerRequestInterface;
use ZfrShopify\Exception;

/**
 * Validate an incoming request coming from Shopify
 *
 * @author Michaël Gallego
 */
class RequestValidator
{
    /**
     * @link   https://docs.shopify.com/api/authentication/oauth#verification
     * @param  ServerRequestInterface $request
     * @param  string                 $sharedSecret
     * @throws Exception\InvalidRequestException
     */
    public function validateRequest(ServerRequestInterface $request, string $sharedSecret)
    {
        // First step: extract the query params
        $queryParams = $request->getQueryParams();

        $this->validateShopHostname($queryParams);
        $this->validateHmac($queryParams, $sharedSecret);
    }

    /**
     * According to Shopify, a shop hostname must ends by "myshopify.com", and must only contains
     * letters, numbers, dots and hyphens
     *
     * @param  array $queryParams
     * @return void
     * @throws Exception\InvalidRequestException
     */
    private function validateShopHostname(array $queryParams)
    {
        $shop = isset($queryParams['shop']) ? $queryParams['shop'] : '';

        if (preg_match('/^[a-zA-Z0-9.-]*(myshopify.com)$/', $shop) === 1) {
            return;
        }

        throw new Exception\InvalidRequestException('Incoming request from Shopify could not be validated');
    }

    /**
     * Validate the given HMAC
     *
     * @param  array  $queryParams
     * @param  string $sharedSecret
     * @return void
     * @throws Exception\InvalidRequestException
     */
    private function validateHmac(array $queryParams, string $sharedSecret)
    {
        $expectedHmac = isset($queryParams['hmac']) ? $queryParams['hmac'] : '';

        // First step: remove HMAC and signature keys
        unset($queryParams['hmac'], $queryParams['signature']);

        // Second step: keys are sorted lexicographically
        ksort($queryParams);

        $pairs = [];

        foreach ($queryParams as $key => $value) {
            // Third step: "&" and "%" are replaced by "%26" and "%25" in keys and values, and in addition
            // "=" is replaced by "%3D" in keys
            $key   = strtr($key, ['&' => '%26', '%' => '%25', '=' => '%3D']);
            $value = strtr($value, ['&' => '%26', '%' => '%25']);

            $pairs[] = $key . '=' . $value;
        }

        $key = implode('&', $pairs);

        if (hash_equals($expectedHmac, hash_hmac('sha256', $key, $sharedSecret))) {
            return;
        };

        throw new Exception\InvalidRequestException('Incoming request from Shopify could not be validated');
    }
}