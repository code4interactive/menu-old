<?php namespace Code4\old\Menu;

use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\RenderableInterface;
use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection implements RenderableInterface
{
    /**
     * Add menu item to collection.
     *
     * @param MenuItem $menuItem
     * @return \Code4\Platform\Menu\Collection
     */
    public function add(MenuItem $menuItem)
    {
        if($this->count() > 0)
        {
            for($i = 0; $i <= $this->indexOf($this->last()) + 1; $i++)
            {
                if(!$this->offsetExists($i))
                {
                    $this->setAtPosition($i, $menuItem);
                    return $this;
                }
            }
        }

        $this->items[] = $menuItem;

        return $this;
    }

    /**
     * Adds message to collection only if it is unique.
     *
     * @param MenuItem $menuItem
     * @return \Code4\Platform\Menu\Collection
     */
    public function addUnique(MenuItem $menuItem)
    {
        if(!$this->contains($menuItem))
        {
            return $this->add($menuItem);
        }

        return $this;
    }


    /**
     * Sets item at given position.
     *
     * @param $position
     * @param MenuItem $menuItem
     * @return \Code4\Platform\Menu\Collection
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
     * Returns item on a given position.
     *
     * @param $position
     * @return \Code4\Platform\Menu\Collection
     */
    public function getAtPosition($position)
    {
        return $this->offsetGet($position);
    }

    /**
     * Returns aliased message or null if not found.
     *
     * @param $alias
     * @return \Code4\Platform\Menu\Collection|null
     */
    public function getAliased($alias)
    {
        foreach($this as $index => $message)
        {
            if($message->getAlias() == $alias)
            {
                return $message;
            }
        }

        return null;
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
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $output = '';

        foreach($this->items as $message)
        {
            $output .= $message->render();
        }

        return $output;
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}