<?php
return [
    'settings' => [
        'title' => 'Ustawienia',
        'url' => 'settings',
        'icon' => 'wrench',
        'permissions' => [],
        'roles' => [],
        'showInMenu' => 'settings.showInMenu',
        'attributes' => [],
        'collection_attributes' => [],

        'collection' => [
            'ogolne' => [
                'title' => 'Ogólne',
                'url' => 'settings/general',
                'order' => 1
            ],
            'docnumbers' => [
                'title' => 'Numeracja dokumentów',
                'url' => 'settings/numerator',
                'order' => 5
            ],
            'users' => [
                'title' => 'Użytkownicy',
                'url' => 'administration/users',
                'icon' => 'users',
                'order' => 10
            ],
            'roles' => [
                'title' => 'Role',
                'url' => 'administration/roles',
                'permission' => ['roles'],
                'icon' => 'lock',
                'order' => 6
            ]
        ]
    ],
];
