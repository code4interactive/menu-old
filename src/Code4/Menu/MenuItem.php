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

    protected $template = null;

    protected $configRepository = null;

    function __construct($id, $name, $type = null, $url = null, $icon = null, $class = null, $childrenClass = null, $configRepository = null, $template = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->url = $url;
        $this->icon = $icon;
        $this->class = $class;
        $this->childrenClass = $childrenClass;
        $this->configRepository = $configRepository;
        $this->template = $template ? $template : $this->configRepository->get('menu::settings.default_item_template');

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
            $this->children = new MenuCollection($this->id, $this->configRepository);
        }

        return $this->children;
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
        return $this->class;
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

    /**
     * TODO: If isset default template check for parent item template. If is diffrent - use it.
     * @return string
     */
    public function render()
    {
        $view = \View::make($this->template);

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