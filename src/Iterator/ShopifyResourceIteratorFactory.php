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
use Guzzle\Service\Resource\ResourceIteratorFactoryInterface;
use Guzzle\Service\Resource\ResourceIteratorInterface;
use ZfrShopify\Exception\InvalidArgumentException;

/**
 * @author Daniel Gimenes
 */
final class ShopifyResourceIteratorFactory implements ResourceIteratorFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function build(CommandInterface $command, array $options = []): ResourceIteratorInterface
    {
        if (!$this->canBuild($command)) {
            throw new InvalidArgumentException(sprintf(
                'The command "%s" is not traversable',
                $command->getName()
            ));
        }

        return new ShopifyResourceIterator($command, $options);
    }

    /**
     * @inheritDoc
     */
    public function canBuild(CommandInterface $command): bool
    {
        return $command->getOperation()->hasParam('since_id');
    }
}
