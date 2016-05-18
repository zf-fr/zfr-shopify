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
            $this->command['since_id'] = $this->nextToken;
        }

        // Run request and "unwrap" the result
        $result  = $this->command->execute();
        $rootKey = $this->command->getOperation()->getData('root_key');
        $data    = $result[$rootKey] ?? $result;

        // This avoid to do any additional request
        $lastItem        = end($data);
        $this->nextToken = $lastItem['id'] ?? false;

        return $data;
    }
}
