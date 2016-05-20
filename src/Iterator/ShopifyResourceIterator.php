<?php

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
