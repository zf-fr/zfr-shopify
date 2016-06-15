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

namespace ZfrShopify\Model;

use ZfrShopify\Exception;

/**
 * Simple value object that can be re-used whenever you need to interact with a shop domain, by making sure the
 * shop domain is valid
 *
 * @author Michaël Gallego
 */
class ShopDomain
{
    /**
     * @var string
     */
    private $shopDomain;

    /**
     * @param string $shopDomain
     */
    public function __construct(string $shopDomain)
    {
        if (!preg_match('/^[a-zA-Z0-9.-]*(myshopify.com)$/', $shopDomain)) {
            throw new Exception\InvalidArgumentException('Shop domain is invalid');
        }

        $this->shopDomain = $shopDomain;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->shopDomain;
    }

    /**
     * Retrieve the sub-domain only (eg: if domain is "test.myshopify.com", sub-domain will be "test" only)
     *
     * @return string
     */
    public function getSubDomain(): string
    {
        return current(explode('.', $this->shopDomain, 2));
    }
}
