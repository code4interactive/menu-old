<?php
/**
 * User: arturbartczak
 * Date: 30.09.15
 * Time: 13:23
 */

namespace Code4\Menu;

class MenuItem {

    private $key;

    private $url;

    private $icon;

    private $title;

    private $collection;

    private $attributes;

    private $collection_attributes;

    private $active = false;

    public function __construct($key, $item) {
        $this->key = $key;

        $this->url = array_key_exists('url', $item) ? $item['url'] : '';
        $this->icon = array_key_exists('icon', $item) ? $item['icon'] : '';
        $this->attributes = array_key_exists('attributes', $item) ? new Attributes($item['attributes']) : new Attributes();
        $this->collection_attributes = array_key_exists('collection_attributes', $item) ? new Attributes($item['collection_attributes']) : new Attributes();
        $this->title = array_key_exists('title', $item) ? $item['title'] : ucfirst($key);

        if (array_key_exists('collection', $item) && is_array($item['collection'])) {
            $this->collection = new MenuCollection($item['collection']);
        }
    }

    /**
     * Sprawdza czy MenuItem ma potomków
     * @return bool
     */
    public function hasChildren(){
        return (bool) is_a($this->collection, 'Code4\Menu\MenuCollection') ? $this->collection->count() : false;
    }

    /**
     * Sets menu element active
     * @param bool $activate
     */
    public function active($activate = true) {
        if ($activate) {
            $this->attributes->add('class', 'active');
        } else {
            $this->attributes->remove('class', 'active');
        }
        $this->active = true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function is($key) {
        return $key==$this->key;
    }

    /**
     * Przekazuje poszukiwanie do kolekcji
     * @param $key
     * @return bool
     */
    public function has($key) {
        if (!$key || !$this->hasChildren()) { return false; }
        return $this->collection->has($key);
    }

    /**
     * Zwraca potomki
     * @return array|MenuCollection
     */
    public function getChildren() {
        if ($this->hasChildren()) { return $this->collection; }
        return [];
    }

    /**
     * @return Attributes
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * @return Attributes
     */
    public function cAttributes()
    {
        return $this->collection_attributes;
    }



    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     * @return MenuItem $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return MenuItem $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Zwraca formatowany string ikony FontAwesome
     * @return string
     */
    public function renderIcon() {
        return '<i class="fa fa-' . $this->icon . '"></i>';
    }

    /**
     * @param string $icon
     * @return MenuItem $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MenuItem $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Renderuje element
     * @return \Illuminate\View\View
     */
    public function render() {
        return view('menu::item', array('item' => $this))->render();
    }

    public function __toString() {
        return (string) $this->render();
    }

    public function __call($name, $arg) {
        return call_user_func_array(array($this->collection, $name), $arg);
    }
}