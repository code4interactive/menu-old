<?php

namespace Code4\Menu;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractMenu implements MenuInterface {

    private $menu;
    private $name;
    protected $checkRoles;
    protected $checkPermissions;
    protected $showInMenuPermission;
    protected $filesystem;
    protected $url;

    public function __construct($menuName, Filesystem $filesystem, UrlGenerator $url)
    {
        $this->name = $menuName;
        $this->filesystem = $filesystem;
        $this->url = $url;
        //$this->init($this->loadConfig());
    }

    /**
     * Builds menu from passed data
     * @param array $menuItems
     */
    public function build($menuItems)
    {
        $this->menu = new MenuCollection($menuItems);
    }

    //Renderuje menu z wykorzystaniem widoków
    public function render($viewName = 'menu::collection') {

        echo view($viewName, ['items'=>$this->menu]);
        //dd($temp);

    }








    /**
     * Funkcja pomocznicza do ładowania menu
     * @param $yamlFilePath
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadMenuFromYamlFile($yamlFilePath) {
        $file = $this->filesystem->get($yamlFilePath);
        return Yaml::parse($file);
    }

    /**
     * Zwraca nazwę kontenera menu
     * @return string
     */
    public function getMenuName() {
        return $this->menu;
    }

}