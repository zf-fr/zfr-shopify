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

namespace Zfr\Shopify\ShopifyClient;

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\PhpInputStream;
use Zend\Diactoros\Response\RedirectResponse;
use Zfr\Shopify\Exception;

/**
 * Shopify client used to interact with the Shopify API
 *
 * It also offers several utility, to allow generate URLs needed for the OAuth dance, as well
 * as validating incoming request
 *
 * @author Michaël Gallego
 */
class ShopifyClient extends Client
{
    /**
     * @var string
     */
    private $sharedSecret;

    /**
     * @var string
     */
    private $shop;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param string $sharedSecret
     * @param string $shop
     * @param string $accessToken
     * @param string $apiKey
     */
    public function __construct($sharedSecret, $shop, $accessToken = '', $apiKey = '')
    {
        parent::__construct('', [
            'command.params' => [
                'shop'         => (string) $shop,
                'access_token' => (string) $accessToken
            ]
        ]);

        $this->sharedSecret = (string) $sharedSecret;
        $this->shop         = (string) $shop;
        $this->accessToken  = (string) $accessToken;
        $this->apiKey       = (string) $apiKey;

        $this->setUserAgent('zfr-shopify-php', true);

        $this->setDescription(ServiceDescription::factory(__DIR__ . '/ServiceDescription/Shopify-v1.php'));
    }

    /**
     * Set an access token
     *
     * This is often useful when you are dynamically retrieving the access token of a shop,
     * and set it as the client access token
     *
     * @param  string $accessToken
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = (string) $accessToken;
        $this->getConfig()->set('access_token', $this->accessToken);
    }

    /**
     * Set an API key
     *
     * @param  string $apiKey
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = (string) $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args = [])
    {
        return parent::__call(ucfirst($method), $args);
    }

    /**
     * Validate the incoming request and check if it is valid
     *
     * @link   https://docs.shopify.com/api/authentication/oauth#verification
     * @param  ServerRequestInterface $request
     * @return void
     * @throws Exception\InvalidRequestException
     * @throws Exception\MissingSignatureException
     */
    public function validateRequest(ServerRequestInterface $request)
    {
        $queryParams = $request->getQueryParams();

        $shop      = isset($queryParams['shop']) ? $queryParams['shop'] : null;
        $hmac      = isset($queryParams['hmac']) ? $queryParams['hmac'] : null;
        $timestamp = isset($queryParams['timestamp']) ? $queryParams['timestamp'] : null;

        if ($shop === null || $hmac === null || $timestamp === null) {
            throw new Exception\MissingSignatureException('Incoming request do not contain any Shopify data to validate signature');
        }

        $this->validateShopHostname($shop);
        $this->validateHmac($shop, $timestamp, $hmac);
    }

    /**
     * Validate the webhook coming from Shopify
     *
     * @link   https://docs.shopify.com/api/webhooks/using-webhooks#verify-webhook
     * @param  ServerRequestInterface $request
     * @return void
     * @throws Exception\InvalidWebhookException
     */
    public function validateWebhook(ServerRequestInterface $request)
    {
        $hmac = $request->getHeaderLine('X-Shopify-Hmac-SHA256');

        if (empty($hmac)) {
            throw new Exception\InvalidRequestException('Incoming Shopify webhook could not be validated');
        }

        $data           = new PhpInputStream();
        $calculatedHmac = base64_encode(hash_hmac('sha256', $data->getContents(), $this->sharedSecret, true));

        if (hash_equals($hmac, $calculatedHmac)) {
            return;
        }

        throw new Exception\InvalidRequestException('Incoming Shopify webhook could not be validated');
    }

    /**
     * Create an authorization redirection request
     *
     * Please note that this method will automatically generate a nonce value. You are responsible to
     * persist it in database, and validate it during the OAuth dance
     *
     * @param  string $shop
     * @param  array  $scopes
     * @param  string $redirectionUri
     * @return ResponseInterface
     * @throws Exception\MissingApiKeyException
     */
    public function createAuthorizationRequest($shop, $scopes, $redirectionUri)
    {
        if (empty($this->apiKey)) {
            throw new Exception\MissingApiKeyException('A Shopify API key is needed to do the OAuth dance');
        }

        $uri = sprintf(
            'https://%s.myshopify.com/admin/oauth/authorize?client_id=%s&scope=%s&redirect_uri=%s&state=%s',
            $shop,
            $this->apiKey,
            implode(',', $scopes),
            $redirectionUri,
            str_replace('.', '', uniqid('', true))
        );

        return new RedirectResponse($uri);
    }

    /**
     * According to Shopify, a shop hostname must ends by "myshopify.com", and must only contains
     * letters, numbers, dots and hyphens
     *
     * @param  string $shop
     * @return void
     * @throws Exception\InvalidRequestException
     */
    private function validateShopHostname($shop)
    {
        if (preg_match('/^[a-zA-Z0-9.-]*(myshopify.com)$/', $shop) === 1) {
            return;
        }

        throw new Exception\InvalidRequestException('Incoming request from Shopify could not be validated');
    }

    /**
     * Validate the given HMAC
     *
     * @param  string $shop
     * @param  string $timestamp
     * @param  string $hmac
     * @return void
     * @throws Exception\InvalidRequestException
     */
    private function validateHmac($shop, $timestamp, $hmac)
    {
        // &, % and = are replaced by %26, %25 and %3D, respectively
        $key = 'shop=' . $shop . '&timestamp=' . $timestamp;
        $key = strtr($key, ['&' => '%26', '%' => '%25', '=' => '%3D']);

        if (hash_equals($hmac, hash_hmac('sha256', $key, $this->sharedSecret))) {
            return;
        };

        throw new Exception\InvalidRequestException('Incoming request from Shopify could not be validated');
    }
}