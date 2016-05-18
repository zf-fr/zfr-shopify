<?php

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
