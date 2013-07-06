Usage


Obiekt Menu:: pozwala na dodawanie pozycji i tworzenie dowolnej ilości kontenerów do ich przechowywania.

Aby utworzyć kontener wystarczy wywołać jego nazwę na obiekcie Menu:

```php

Menu::topMenu()->add($items);
Menu::wlasnyKontener()->add($items);

```

Możliwe jest także załadowanie kilku kontenerów z konfiguracji. Aby to wykonać należy przekazać obiekt typu Illuminate\Config\Repository
lub zwykły array następującej struktury:

```php

array(

    'menus' => array(

        'nazwaKontenera' => array(
            'settings' => array(

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
        'nazwaDrugiegoKontenera' => array(
            ...
        )
    )
)

```


Params:

* id: unikalny identyfikator
* name: wyświetlana nazwa
* type: typ - dowolny - do zaimplementowania w widokach modułu  - typ wbudowany w domyślny template to: subHeader
* url: link
* icon: klasa css ikony np: icon_home. Można używać gotowej klasy wbudowanej w platformę Icons->$icon_home;
* class: dodatkowe klasy css do stylizacji
* childrenClass: klasy do stylizacji submenu jeśli występuje


Dodanie pojedynczej pozycji menu poprzez array()

```php
$item = array(

    'id' => 'id',               //required
    'name' => 'name',           //required
    'type' => 'type',
    'url' => 'url',
    'icon' => 'icon',
    'class' => 'class',
    'childrenClass' => 'childrenClass'

    //Jeśli chcesz dodać od razu submenu można to zrobić tak:
    'children' => array(
        1 => array(
            'id' => 'submenu',
            'name' => 'Submenu'
        ),
        100 => array(
            'id' => 'submenu2',
            'name' => 'Submenu2'
        )
    )

);

$position = 10;

Menu::topMenu()->add($item)->at($position);
```

Dodawanie wielu pozycji z własnego configu lub tablicy odbywa się analogicznie z pominięciem at().

```php

$array = array(
     0 => array(
         'id' => 'main',
         'name' => 'Strona główna',
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

Menu::topMenu()->add($array);

```

Dodanie pozycji menu poprzez Closure:

```php

Menu::topMenu()->add(function($menuItem){

    $menuItem->setId = 'id';
    $menuItem->setName = 'name';
    $menuItem->setType = 'type';
    $menuItem->setUrl = 'url';
    $menuItem->setIcon = 'icon';
    $menuItem->setClass = 'class';
    $menuItem->setChildrenClass = 'childrenClass';

    //Jeśli chcesz dodać submenu można to zrobić od razu także przez closure:
    $menuItem->getChildren()->add(function($submenu) {

        $submenu->setId = 'id';
        $submenu->setName = 'name';
        //....

    })->at(0);

    //Albo arrayem
    $menuItem->getChildren()->add(array(

          'id' => 'id',               //required
          'name' => 'name',           //required
          'type' => 'type',
          'url' => 'url',
          'icon' => 'icon',
          'class' => 'class',
          'childrenClass' => 'childrenClass',
          'children' => null | array()

    ))->at(1);

})->at($position);

```