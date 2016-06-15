<?php

namespace ZfrShopify;

/**
 * @author Daniel Gimenes
 */
final class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
