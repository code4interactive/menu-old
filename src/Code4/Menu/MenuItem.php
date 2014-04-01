<?php
namespace Code4\Menu;

use Illuminate\Config\Repository;
use Illuminate\Routing\Route;
use Illuminate\Support\Contracts\JsonableInterface;
use Illuminate\Support\Contracts\ArrayableInterface;
use Illuminate\Support\Contracts\RenderableInterface;
use Illuminate\View\View;

class MenuItem implements JsonableInterface, ArrayableInterface, RenderableInterface
{

    protected $id = null;

    protected $name = null;

    protected $type = null;

    protected $url = null;

    protected $icon = null;

    protected $class = null;

    protected $isChild = false;

    protected $childrenClass = null;

    protected $children = null;

    protected $settings = null;

    protected $configRepository = null;

    protected $lvl = null;

    protected $active = false;

    protected $open = false;

    protected $additional = null;

    function __construct($id, $name, $item = array(), $configRepository = null, $settings = null, $lvl = null)
    {
        $this->id = $id;
        $this->name = $name;

        $this->type = isset($item['type'])?$item['type']:null;
        $this->url = isset($item['url'])?$item['url']:null;
        $this->icon = isset($item['icon'])?$item['icon']:null;
        $this->class = isset($item['class'])?$item['class']:null;
        $this->childrenClass = isset($item['childrenClass'])?$item['childrenClass']:null;
        $this->active = isset($item['active'])?$item['active']:false;
        $this->open = isset($item['open'])?$item['open']:false;
        $this->additional = isset($item['additional'])?$item['additional']:false;

        $this->configRepository = $configRepository;
        $this->settings = $settings ? $settings : $this->configRepository->get('menu::settings');
        $this->lvl = $lvl;

    }

    public function setConfigRepository($configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function setChildren(MenuCollection $children)
    {
        $this->children = $children;
    }

    public function getChildren()
    {

        if (!($this->children instanceof MenuCollection)) {
            $this->children = new MenuCollection($this->id, $this->configRepository, $this->settings, $this->lvl+1);
        }

        return $this->children;
    }

    /**
     * Sprawdzamy ścieżkę i zaznaczamy odpowiednie elementy jeżeli ścieżka się zgadza
     * @param  string $path Ścieżka do sprawdzenia
     * @return bool
     */
    public function checkPath($path) {

        if (trim($this->url, "/") == $path) {
            $this->setActive(true);
            $this->setOpen(true);
            return true;
        } else {
            if ($this->hasChildren()) {
                
                foreach($this->getChildren()->all() as $item) {

                    if ($item->checkPath($path)) {
                        $this->setOpen(true);
                        return true;
                    }

                }

            }
        }

    }

    public function setChildrenClass($childrenClass)
    {
        $this->childrenClass = $childrenClass;
    }

    public function getChildrenClass()
    {
        return $this->childrenClass;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        $temp = $this->class;
        if ($this->open) $temp .= " open";
        if ($this->active) $temp .= " active";

        return $temp;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function hasChildren() {

        return $this->children instanceof MenuCollection && $this->children->count() > 0 ? true : false;

    }

    public function setIsChild($isChild)
    {
        $this->isChild = $isChild;
    }

    public function getIsChild()
    {
        return $this->isChild;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function isActive()
    {
        return $this->active?true:false;
    }

    public function getOpen()
    {
        return $this->open;
    }

    public function setOpen($open)
    {
        $this->open = $open;
    }

    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }

    public function getAdditional()
    {
        return $this->additional;
    }

    public function add($item)
    {
        return $this->getChildren()->add($item);
    }

    public function at($index)
    {
        return $this->getChildren()->at($index);
    }

    public function find($id)
    {
        if ($this->hasChildren()) return $this->getChildren()->find($id);
        return null;
    }

    public function setActivePath($id)
    {
        if ($this->id == $id) {
            $this->setOpen(true);
            $this->setActive(true);
            return $this;
        }
        elseif ($this->hasChildren()) return $this->getChildren()->setActivePath($id);
        return null;
    }

    /**
     * TODO: If isset default template check for parent item template. If is different - use it.
     * @return string
     */
    public function render()
    {

        if (!\View::exists($this->settings['item_template'])) return "Menu item template: ".$this->settings['item_template']." don't exist";

        $view = \View::make($this->settings['item_template']);

        $view->menuItem = array($this);

        return $view->render();

    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * Evaluates object as string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }
}