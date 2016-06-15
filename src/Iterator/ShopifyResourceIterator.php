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

namespace ZfrShopify\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;

/**
 * @author Daniel Gimenes
 */
final class ShopifyResourceIterator extends ResourceIterator
{
    /**
     * @param CommandInterface $command
     * @param array            $data
     */
    public function __construct(CommandInterface $command, array $data = [])
    {
        parent::__construct($command, $data);

        $this->pageSize = 250; // This is the maximum allowed by Shopify
    }

    /**
     * {@inheritDoc}
     */
    protected function sendRequest()
    {
        $this->command['limit'] = $this->pageSize;

        if ($this->nextToken) {
            $this->command['page'] = $this->nextToken;
        }

        // Run request and "unwrap" the result
        $result  = $this->command->execute();
        $rootKey = $this->command->getOperation()->getData('root_key');
        $data    = $result[$rootKey] ?? $result;

        // Check if reached last page
        if (count($data) === $this->pageSize) {
            $this->nextToken = $this->nextToken ? $this->nextToken + 1 : 2;
        } else {
            $this->nextToken = false;
        }

        return $data;
    }
}
