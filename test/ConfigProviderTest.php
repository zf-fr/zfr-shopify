<?php

namespace ZfrShopifyTest;

use ZfrShopify\ConfigProvider;

/**
 * @author Daniel Gimenes
 */
final class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProvidesContainerConfig()
    {
        $moduleConfig = new ConfigProvider();
        $config       = $moduleConfig();

        $this->assertArrayHasKey('dependencies', $config);
    }
}
