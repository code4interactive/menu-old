<?php
/**
 * Created by CODE4 Interactive.
 * User: Artur Bartczak
 * Date: 27.06.13
 * Time: 17:36
 */

namespace Code4\Menu;

use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Contracts\RenderableInterface;

class MenuCollection extends Collection implements RenderableInterface {

    protected $container;

    protected $configRepository;

    protected $lastIndex;

    protected $lastItem;

    protected $nextIndex;

    protected $itemToAdd;

    public function __construct($container, Repository $configRepository) {

        $this->container = $container;
        $this->configRepository = $configRepository;

    }

    public function add($item) {

        $this->lastIndex = null;

        if ($item instanceof MenuItem) {

            $this->itemToAdd = $item;

        } else if (is_array($item)) {

            $this->itemToAdd = $this->addArrayItems($item);

        } else if (is_callable($item)) {

            $menuItem = new MenuItem(null, null, null, null, null, null, null, $this->configRepository);

            $this->itemToAdd = $item($menuItem);
        }

        return $this;
    }

    private function addArrayItems(array $items) {

        if (isset($items['id'])) {

            return $this->addArray($items);

        }
        else {

            foreach($items as $index => $item) {

                $this->add($item)->at($index);

            }

        }

        return $this;

    }

    private function addArray($item) {

        $type = isset($item['type'])?$item['type']:null;
        $url = isset($item['url'])?$item['url']:null;
        $icon = isset($item['icon'])?$item['icon']:null;
        $class = isset($item['class'])?$item['class']:null;
        $childrenClass = isset($item['childrenClass'])?$item['childrenClass']:null;

        $menuItem = new MenuItem($item['id'], $item['name'], $type, $url, $icon, $class, $childrenClass, $this->configRepository);

        if (isset($item['children']) && is_array($item['children']))
        {

            $childCollection = new MenuCollection($item['id'], $this->configRepository);

            foreach ($item['children'] as $index => $child)
            {

                $childCollection->add($child)->at($index);

            }

            $menuItem->setChildren($childCollection);

        }

        return $menuItem;
    }

    public function at($index = null, $overwrite = false)
    {
        if (is_null($index)) {

            if($this->count() > 0)
            {
                for($i = 0; $i <= $this->indexOf($this->last()) + 1; $i++)
                {
                    if(!$this->offsetExists($i))
                    {
                        $index = $i;
                        break;
                    }
                }
            } else {
                $this->items = array();
                $index = 0;
            }

        }

        if (is_numeric($index)) {

            //istnieje itemtoadd wiec go ustawiamy na okreslonym wczesniej index
            if ($this->itemToAdd != null) {

                if ($overwrite)
                    $this->items[$index] = $this->itemToAdd;
                else
                    $this->setAtPosition($index, $this->itemToAdd);

                $this->itemToAdd = null;
                return $this;
            }

            if (!$this->offsetExists($index)) return null;

            return $this->offsetGet($index);
        }

        if (is_string($index)) {

            foreach($this as $menuIndex => $menuItem)
            {
                if($menuItem->getId() == $index)
                {
                    return $menuItem;
                }
            }

            return null;

        }

    }



    /**
     * Returns index value of a given message.
     *
     * @param MenuItem $menuItem
     * @return bool|int
     */
    public function indexOf(MenuItem $menuItem)
    {
        foreach($this as $index => $m)
        {
            if($menuItem === $m)
            {
                return $index;
            }
        }

        return false;
    }

    /**
     * Sets item at given position.
     *
     * @param $position
     * @param MenuItem $menuItem
     * @return $this
     */
    public function setAtPosition($position, MenuItem $menuItem)
    {
        $tmp = array();

        array_set($tmp, $position, $menuItem);

        foreach($this->items as $key => $item)
        {
            $i = $key;
            while(array_key_exists($i, $tmp))
            {
                $i++;
            }
            $tmp[$i] = $item;
        }

        $this->items = $tmp;

        ksort($this->items);

        return $this;
    }


    public function render() {

       $view = \View::make('menu::default.layout')->with("menuCollection", array($this));
       return $view;

    }

    public function __toString() {
        return (string) $this->render();
    }

}