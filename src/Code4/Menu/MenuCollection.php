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

    protected $settings;

    protected $lastIndex;

    protected $lastItem;

    protected $nextIndex;

    protected $itemToAdd;

    protected $lvl;

    public function __construct($container, Repository $configRepository, $settings = array(), $lvl) {

        $this->container = $container;
        $this->configRepository = $configRepository;
        $this->lvl = $lvl;

        $settings['layout_template'] = isset($settings['layout_template']) ? $settings['layout_template'] : $this->configRepository->get("menu::settings.default_layout_template");
        $settings['item_template'] = isset($settings['item_template']) ? $settings['item_template'] : $this->configRepository->get("menu::settings.default_item_template");

        $this->settings = $settings;

    }

    public function loadSettings($settings = array()) {

        $settings['layout_template'] = isset($settings['layout_template']) ? $settings['layout_template'] : $this->configRepository->get("menu::settings.default_layout_template");
        $settings['item_template'] = isset($settings['item_template']) ? $settings['item_template'] : $this->configRepository->get("menu::settings.default_item_template");

        $this->settings = $settings;

    }

    public function add($item) {

        $this->lastIndex = null;

        if ($item instanceof MenuItem) {

            $this->itemToAdd = $item;

        } else if (is_array($item)) {

            $this->itemToAdd = $this->addArrayItems($item);

        } else if (is_callable($item)) {

            $menuItem = new MenuItem(null, null, array(), $this->configRepository, $this->settings, $this->lvl);

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

        $menuItem = new MenuItem($item['id'], $item['name'], $item, $this->configRepository, $this->settings, $this->lvl);

        if (isset($item['children']) && is_array($item['children']))
        {
            $childCollection = new MenuCollection($item['id'], $this->configRepository, $this->settings, $this->lvl+1);
            $childCollection->loadSettings($this->settings);

            foreach ($item['children'] as $index => $child)
            {

                $childCollection->add($child)->at($index);

            }

            $menuItem->setChildren($childCollection);

        }

        return $menuItem;
    }

    /**
     * Stores last added item at given offset, or returns item from given offset
     * If no offset given - stores last item at first empty location
     *
     * @param null|int|string $index
     * @param bool $overwrite
     * @return $this|mixed|null|MenuItem
     */
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

            //Nie istnieje wiec zwracamy
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

    /**
     * Recurrent search of element by Id
     * @param $id
     * @return null | \Code4\Menu\
     */
    public function find($id) {

        foreach ($this->all() as $item) {

            $found = null;

            if ($item->getId == $id) $found = $item;

            else $found = $item->find($id);

            if ($found) return $found;

        }
        return null;

    }

    public function setActivePath($id) {

        foreach ($this->all() as $item) {

            $found = $item->setActivePath($id);

            if ($found) {

                $item->setOpen(true);
                return $item;

            }

        }
        return null;
    }

    /**
     * Sprawdzamy bierzącą lub zadaną ścieżkę i zaznaczamy odpowiednie pozycje menu
     * @param  string $path Ścieżka 
     * @return null
     */
    public function checkRoutesForCurrent($path = null) {

        if (is_null($path))
            $path = \Route::getCurrentRoute()->getPath();

        foreach ($this->all() as $item) {
            if ($item->checkPath($path)) break;
        }

    }

    public function isLast(MenuItem $item) {

        return $this->last()->getId() == $item->getId();

    }

    public function render() {

        if (!\View::exists($this->settings['layout_template'])) return "Menu collection template: ".$this->settings['layout_template']." don't exist";

        if ($this->count() == 0) return "Menu collection is empty";

        $this->checkRoutesForCurrent();

        $view = \View::make($this->settings['layout_template'])->with("menuCollection", array($this));
        return $view;

    }

    public function __toString() {

        return (string) $this->render();
    }

}