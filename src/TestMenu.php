<?php

namespace Code4\Menu;

class TestMenu extends AbstractMenu {

    protected $checkRoles = false;
    protected $checkPermissions = false;
    protected $name = 'TestMenu';

    public function getConfig()
    {
        return $this->loadMenuFromYamlFile(app_path('../config').'/menu-main.yaml');
        //return \Config::get('menu-main');
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasAccess($permission) {
        return true;
    }

    /**
     * @param $role
     * @return bool
     */
    public function inRole($role) {
        return true;
    }

}