<?php
/**
 * Created by CODE4Interactive.
 * User: Artur Bartczak
 * Date: 05.07.13
 * Time: 13:53
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


    public function container($container = null) {

        $container = is_null($container) ? $this->configRepository->get('menu::settings.default_menu'):$container;

        if (!isset($this->containers[$container]))
        {
            $this->containers[$container] = new MenuCollection($container, $this->configRepository);
        }

        return $this->containers[$container];
    }


    public function loadMenuFromConfig(Repository $configRepository) {

        foreach ($configRepository->get('menu::menus') as $containerName => $container) {

            $this->container($containerName)->add($container['items']);

            /*foreach($container['items'] as $index => $menuItem)
            {
                $this->container($containerName)->add($menuItem)->at($index);
            }*/

        }

    }

    public function getConfigRepository()
    {
        return $this->configRepository;
    }



    public function addToMenu() {



    }


    /**
     * Calls methods on given container. Eg. Menu::topMenu()->add($item);
     *
     * @param $name
     * @param $arguments
     * @return container
     */
    public function __call($name, $arguments) {
        //return call_user_func_array(array($this->container($name), $name), $arguments);

        return $this->container($name);

    }
}