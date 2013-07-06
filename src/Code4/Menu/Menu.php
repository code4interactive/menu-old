<?php
/**
 * Created by CODE4Interactive.
 * User: Artur Bartczak
 * Date: 05.07.13
 * Time: 13:53
 *
 */

namespace Code4\Menu;

use Illuminate\Config\Repository;

class Menu {

    protected $configRepository;

    protected $containers;

    public function __construct(Repository $configRepository) {

        $this->configRepository = $configRepository;

        $this->loadMenuFromConfig($this->configRepository);
    }


    public function container($container = null, $settings = null) {

        $container = is_null($container) ? $this->configRepository->get('menu::settings.default_menu_name'):$container;

        if (!isset($this->containers[$container]))
        {
            $this->containers[$container] = new MenuCollection($container, $this->configRepository, $settings, 0);
        }

        return $this->containers[$container];
    }


    public function loadMenuFromConfig($config) {

        if ($config instanceof Repository) {
            $menus = $config->get('menu::menus');
        }
        else {
            $menus = $config;
        }

        foreach ($menus as $containerName => $container) {

            if (isset($container['settings'])) {

                $this->container($containerName, $container['settings']);

            }

            $this->container($containerName)->add($container['items']);

        }
    }

    public function find($id) {



    }

    /*public function getConfigRepository() {

        return $this->configRepository;

    }*/

    /**
     * Call method to make and return container
     * Eg. Menu::topMenu()->add($item);
     *
     * @param $name
     * @param $arguments //settings
     * @return container
     */
    public function __call($name, $arguments) {

        $arguments = sizeof($arguments)>0?$arguments[0]:null;

        return $this->container($name, $arguments);

    }
}