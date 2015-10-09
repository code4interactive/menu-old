<?php
namespace Code4\Menu;

use Illuminate\Routing\UrlGenerator;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class Menu {
    private $filesystem;
    private $config;
    private $url;
    private $html;

    protected $menus = [];

    public function __construct(Filesystem $filesystem, Repository $config, UrlGenerator $url) {
        $this->filesystem = $filesystem;
        $this->config = $config;
        $this->url = $url;
    }

    /**
     * Inicjalizuje menu ładując wszystkie menu z konfiguracji
     * @throws \Exception
     */
    public function init() {
        if (($menus = $this->config->get('menu.menus')) == null) {
            throw new \Exception('Config not found! Make sure to publish resources!');
        }

        foreach ($menus as $menuName => $menu) {
            $this->menus[$menuName] = new $menu($menuName, $this->filesystem, $this->url);
            $menuData = $this->menus[$menuName]->getConfig();

            $this->menus[$menuName]->build($menuData);
        }
    }


    /**
     * Gets menu from collection for chaining
     * @param string $menuName
     * @return AbstractMenu mixed
     * @throws \Exception
     */
    public function get($menuName) {
        if ( !array_key_exists($menuName, $this->menus))
        {
            throw new \Exception('Menu '.$menuName.' not found!');
        }
        return $this->menus[$menuName];
    }






    ////HELPERS

    /**
     * Ładuje konfigurację z pliku konfiguracyjnego
     * @param $config
     * @return mixed
     */
    public function loadMenuFromConfig($config) {
        return $this->config->get($config);
    }


    /**
     * Ładuje i parsuje zawartość pliku wskazanego ścieżką
     * @param $yamlPath
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadMenuFromYamlFile($yamlPath) {
        $file = $this->filesystem->get($yamlPath);
        return Yaml::parse($file);
    }


}