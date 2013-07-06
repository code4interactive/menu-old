<?php

return array(

    'settings' => array(
        'default_menu_name' => 'topMenu',
        'layout_template' => 'menu::default.layout',
        'item_template' => 'menu::default.item'
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
        )
    )
);
