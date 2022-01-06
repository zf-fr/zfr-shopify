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

namespace ZfrShopifyTest\OAuth;

use ZfrShopify\OAuth\AuthorizationRedirectResponse;
use PHPUnit\Framework\TestCase;

/**
 * @author Michaël Gallego
 */
class AuthorizationRedirectResponseTest extends TestCase
{
    public function shopDomainProvider()
    {
        return [
            ['mystore'],
            ['mystore.myshopify.com']
        ];
    }

    /**
     * @dataProvider shopDomainProvider
     */
    public function testCanCreateAuthorizationReponse($shop)
    {
        $scopes   = ['read_content', 'write_content'];
        $response = new AuthorizationRedirectResponse('app_123', $shop, $scopes, 'https://www.mysite.com', 'nonce');
        $location = $response->getHeaderLine('Location');

        $this->assertEquals(302, $response->getStatusCode());

        $this->assertContains('https://mystore.myshopify.com/admin/oauth/authorize', $location);
        $this->assertContains('client_id=app_123', $location);
        $this->assertContains('scope=read_content,write_content', $location);
        $this->assertContains('redirect_uri=https://www.mysite.com', $location);
        $this->assertContains('state=', $location);
    }
}
