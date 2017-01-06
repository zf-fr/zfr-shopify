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

namespace ZfrShopify\OAuth;

use GuzzleHttp\ClientInterface;
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
    public function exchangeCodeForToken(
        string $apiKey,
        string $sharedSecret,
        string $shopDomain,
        array $requiredScopes,
        string $code
    ): string {
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
