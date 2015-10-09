<?php
namespace Code4\Menu\Test;

use \Code4\Menu\MenuCollection;

class MenuCollectionTest extends TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testHas()
    {
        $menuCollection = new MenuCollection($this->exampleMenu);

        $this->assertEquals(true,   $menuCollection->has('settings'), 'First level existing');
        $this->assertEquals(false,  $menuCollection->has('notExisting'), 'First level not existing');
        $this->assertEquals(true,   $menuCollection->has('settings.ogolne'), 'Second level existing');
        $this->assertEquals(false,  $menuCollection->has('settings.notExisting'), 'Second level not existing');
    }

    public function testOrder()
    {
        $menuCollection = new MenuCollection($this->exampleOrder);

        //Test list order
        $lp = 1;
        foreach($menuCollection->toArray() as $el) {
            $this->assertEquals('pos'.$lp, $el->getKey(), 'Menu item "'.$el->getKey().' order: '.$lp.'');
            $lp++;
        }

        //Test setting the order
        $menuCollection->setOrder('pos1', 2);
        $this->assertEquals('pos1', $menuCollection->toArray()[1]->getKey());
    }
}
