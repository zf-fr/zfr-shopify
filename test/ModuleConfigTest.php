<?php

namespace ZfrShopifyTest;

use ZfrShopify\ModuleConfig;

/**
 * @author Daniel Gimenes
 */
final class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testProvidesContainerConfig()
    {
        $moduleConfig = new ModuleConfig();
        $config       = $moduleConfig();

        $this->assertArrayHasKey('dependencies', $config);
    }
}
