<?php
namespace Code4\Menu\Test;

use Code4\Menu\MenuItem;

class MenuItemTest extends TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testIs()
    {
        $menuItem = new MenuItem('settings', []);
        $this->assertEquals(true, $menuItem->is('settings'));
    }
}