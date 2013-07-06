<?php

return array(

    'settings' => array(
        'default_menu_name' => 'topMenu',
        'default_layout_template' => 'menu::default.layout',
        'default_item_template' => 'menu::default.item'
    ),

    'menus' => array(

        'topMenu' => array(
            'settings' => array(
                'layout_template' => 'menu::topMenu.layout',
                'item_template' => 'menu::topMenu.item'
            ),
            'items' => array(
                0 => array(
                    'id' => 'main',
                    'name' => 'Strona główna',
                    'type' => 'default',  //or null
                    'url' => '#',
                    'icon' => Icons::$icon_home,
                    'class' => 'purple',
                    'children' => null,
                    'childrenClass' => null
                ),
                100 => array (
                    'id' => 'admin',
                    'name' => 'Administracja',
                    'type' => null,
                    'url' => '#',
                    'icon' => Icons::$icon_cog,
                    'class' => 'grey',
                    'childrenClass' => null,
                    'children' => array(
                        1 => array(
                            'id' => 'head',
                            'name' => 'Header',
                            'type' => 'subHeader',
                        ),
                        10 => array(
                            'id' => 'userManagment',
                            'name' => 'Użytkownicy',
                            'url' => '#',
                            'icon' => Icons::$icon_user
                        )
                    )
                )
            )
        ),
        'leftMenu' => array(
            'settings' => array(
                'layout_template' => 'menu::leftMenu.layout',
                'item_template' => 'menu::leftMenu.item'
            ),
            'items' => array()
        )
    ),



    'leftmenu' => array(
        'root' => array(
            1 => array(
                'id' => 'main',
                'name' => 'Strona główna',
                'url' => '#',//action('HomeController@getIndex'),
                'icon' => 'icon-home',
                'roles' => array('all'),
                'style' => 'purple',
                'sub-style' => 'navbar-pink'
            ),
            1000 => array (
                'id' => 'admin',
                'name' => 'Administracja',
                'url' => '#',
                'icon' => 'icon-cog',
                'roles' => array('all'),
                'style' => 'grey'
            )
        ),
        'admin' => array(
            1 => array(
                'id' => 'head',
                'name' => 'Header',
                'type' => 'sub-header',
                'icon' => '',
                'roles' => array('all')
            ),
            10 => array(
                'id' => 'userManagment',
                'name' => 'Użytkownicy',
                'url' => '',
                'icon' => 'icon-user',
                'roles' => array('all')
            )
        )
    )

);
