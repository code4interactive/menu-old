<?php

namespace Code4\Menu\Test;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $exampleMenu = [
        'settings' => [
            'title'       => 'Ustawienia',
            'url'         => 'settings',
            'icon'        => 'wrench',
            'permissions' => [],
            'roles'       => [],
            'attributes'  => [

            ],
            'showInMenu'  => 'settings.showInMenu',
            'collection'  => [
                'ogolne'     => [
                    'title' => 'Ogólne',
                    'url'   => 'settings/general',
                    'order' => 1
                ],
                'docnumbers' => [
                    'title' => 'Numeracja dokumentów',
                    'url'   => 'settings/numerator',
                    'order' => 5
                ],
                'users'      => [
                    'title' => 'Użytkownicy',
                    'url'   => 'administration/users',
                    'icon'  => 'users',
                    'order' => 10
                ],
                'roles'      => [
                    'title'      => 'Role',
                    'url'        => 'administration/roles',
                    'permission' => ['roles'],
                    'icon'       => 'lock',
                    'order'      => 6
                ]
            ]
        ]
    ];

    protected $exampleMenuItem = [
        'title'       => 'Ustawienia',
        'url'         => 'settings',
        'icon'        => 'wrench',
        'permissions' => [],
        'roles'       => [],
        'showInMenu'  => 'settings.showInMenu'
    ];



    protected $exampleOrder = [
        'pos1' => [
            'title'       => 'Ustawienia',
            'order'        => 10
        ],
        'pos2' => [
            'title'       => 'Ustawienia',
            'order'        => 20
        ],
        'pos4' => [
            'title'       => 'Ustawienia',
            'order'        => 50
        ],
        'pos5' => [
            'title'       => 'Ustawienia'
        ],
        'pos3' => [
            'title'       => 'Ustawienia',
            'order'        => 40
        ],
        'pos6' => [
            'title'       => 'Ustawienia',
            'order'        => 60
        ]
    ];
}
