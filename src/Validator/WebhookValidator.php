<?php

namespace ZfrShopify\Validator;

use Psr\Http\Message\ServerRequestInterface;
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
    public function validateWebhook(ServerRequestInterface $request, string $sharedSecret)
    {
        $hmac = $request->getHeaderLine('X-Shopify-Hmac-Sha256');

        if (empty($hmac)) {
            throw new Exception\InvalidWebhookException('Incoming Shopify webhook could not be validated');
        }

        $calculatedHmac = base64_encode(hash_hmac('sha256', (string) $request->getBody(), $sharedSecret, true));

        if (hash_equals($hmac, $calculatedHmac)) {
            return;
        }

        throw new Exception\InvalidWebhookException('Incoming Shopify webhook could not be validated');
    }
}
