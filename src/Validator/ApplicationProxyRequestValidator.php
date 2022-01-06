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
 * Validate an incoming application proxy request coming from Shopify
 *
 * @author Michaël Gallego
 */
class ApplicationProxyRequestValidator
{
    /**
     * @link   https://help.shopify.com/api/tutorials/application-proxies#security
     * @param  ServerRequestInterface $request
     * @param  string                 $sharedSecret
     * @throws Exception\InvalidRequestException
     */
    public function validateRequest(ServerRequestInterface $request, string $sharedSecret)
    {
        // First step: extract the query params
        $queryParams = $request->getQueryParams();

        $this->validateShopHostname($queryParams);
        $this->validateSignature($queryParams, $sharedSecret);
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
     * Validate the given signature
     *
     * @param  array  $queryParams
     * @param  string $sharedSecret
     * @return void
     * @throws Exception\InvalidApplicationProxyRequestException
     */
    private function validateSignature(array $queryParams, string $sharedSecret)
    {
        $expectedSignature = $queryParams['signature'] ?? '';

        // First step: remove signature keys
        unset($queryParams['signature']);

        // Second step: keys are sorted lexicographically
        ksort($queryParams);

        // Contrary to request validations, apparently special characters like "&" and "%" are not replaced.
        // Additionally, each pairs is not separated by &
        $pairs = [];

        foreach ($queryParams as $key => $value) {
            $value   = is_array($value) ? implode(',', $value) : $value;
            $pairs[] = $key . '=' . $value;
        }

        $signature = implode('', $pairs);

        if (hash_equals($expectedSignature, hash_hmac('sha256', $signature, $sharedSecret))) {
            return;
        }

        throw new Exception\InvalidApplicationProxyRequestException(
            'Incoming application proxy request from Shopify could not be validated'
        );
    }
}
