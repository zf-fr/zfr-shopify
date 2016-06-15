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
