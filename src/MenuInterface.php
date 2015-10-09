<?php
namespace Code4\Menu;

interface MenuInterface {

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param $permission
     * @return bool
     */
    public function hasAccess($permission);

    /**
     * @param $role
     * @return bool
     */
    public function inRole($role);
}