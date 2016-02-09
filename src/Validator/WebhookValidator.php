<?php

namespace ZfrShopify\Validator;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\PhpInputStream;
use ZfrShopify\Exception;

/**
 * Validate an incoming webhook request coming from Shopify
 *
 * @author Michaël Gallego
 */
class WebhookValidator
{
    /**
     * @link  https://docs.shopify.com/api/webhooks/using-webhooks#verify-webhook
     * @param ServerRequestInterface $request
     * @param string                 $sharedSecret Application shared secret to validate against
     */
    public function validate(ServerRequestInterface $request, string $sharedSecret)
    {
        $hmac = $request->getHeaderLine('X-Shopify-Hmac-SHA256');

        if (empty($hmac)) {
            throw new Exception\InvalidRequestException('Incoming Shopify webhook could not be validated');
        }

        $data           = new PhpInputStream();
        $calculatedHmac = base64_encode(hash_hmac('sha256', $data->getContents(), $sharedSecret, true));

        if (hash_equals($hmac, $calculatedHmac)) {
            return;
        }

        throw new Exception\InvalidRequestException('Incoming Shopify webhook could not be validated');
    }
}