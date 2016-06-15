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
use ZfrShopify\Model\ShopDomain;

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
     * @param  array $queryParams
     * @return void
     * @throws Exception\InvalidRequestException
     */
    private function validateShopHostname(array $queryParams)
    {
        try {
            new ShopDomain($queryParams['shop'] ?? '');
        } catch (Exception\InvalidArgumentException $exception) {
            throw new Exception\InvalidRequestException('Incoming request from Shopify could not be validated');
        }
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
        $expectedHmac = $queryParams['hmac'] ?? '';

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
