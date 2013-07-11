Usage


Obiekt Menu:: pozwala na dodawanie pozycji i tworzenie dowolnej ilości kontenerów do ich przechowywania.

Aby utworzyć kontener wystarczy wywołać jego nazwę na obiekcie Menu:

```php

Menu::topMenu()->add($items);
Menu::wlasnyKontener()->add($items);

```

Jeśli chcemy skorzystać z własnego szablonu należy przekazać podczas pierwszego tworzenia kontenera ustawienia:

```php
$settings = array(
    'layout_template' => 'menu::topMenu.layout',
    'item_template' => 'menu::topMenu.item'
)
Menu::wlasnyKontener($settings)->add($items);
```

Możliwe jest także załadowanie kilku kontenerów z konfiguracji. Aby to wykonać należy przekazać obiekt typu Illuminate\Config\Repository
lub zwykły array następującej struktury:

```php

$config = array(

    'menus' => array(

        'nazwaKontenera' => array(
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
        'nazwaDrugiegoKontenera' => array(
            ...
        )
    )
)

Menu::loadMenuFromConfig($config);

```

Pole settings jest opcjonalne.


Params:

* id: unikalny identyfikator
* name: wyświetlana nazwa
* type: typ - dowolny - do zaimplementowania w widokach modułu  - typ wbudowany w domyślny template to: subHeader
* url: link lub named route - jeżeli podano named route system sam sprawdzi czy istnieje i oznaczy pozycję jako active
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

W przypadku dodawania pozycji z metodą at() można przekazać do niej drugi parametr który decyduje o ty czy dodawana pozycja ma nadpisać istniejącą jeśli mają ten sam index

```php

Menu::topMenu()->add($item)->at($position, true);

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

Operowanie na istniejących pozycjach
_______________

```php
//Zmiana pojedynczych pozycji menu
Menu::topMenu()->at(1)->setName('Test');
Menu::topMenu()->at('main')->setName('Test');

//Dodawanie submenu do istniejącej pozycji
Menu::topMenu()->at(1)->getChildren()->add($item)->at(0);
Menu::topMenu()->at('main')->getChildren()->add($item)->at(0);

//Zmiana danych a pozycjach submenu
Menu::topMenu()->at(1)->getChildren()->at(0)->setUrl('http://www.code4.pl/');
Menu::topMenu()->at(1)->getChildren()->at('userManagment')->setUrl('http://www.code4.pl/');

//Wyszukiwanie po Id. Rekurencyjne więc dotyczy także submenu
Menu::find('main')->setName('Test');
Menu::topMenu()->find('main')->setName('Test');
Menu::topMenu()->find('main')->getChildren()->find('submenuItem')->setName('Submenu Item');

```

Operacje na kolekcjach
_______________

```php

//Zmiana ustawien kolekcji
//UWAGA - nie działa jeszcze dziedziczenie ustawień więc nadanie innych widoków zadziała tylko dla elementu któremy ten widok ustawimy.
//W tym przypadku tylko dla kolekcji topMenu (mimo ustawienia itemu)

Menu::topMenu()->loadSettings(
    array(
        'layout_template' => 'menu::topMenu.layout',
        'item_template' => 'menu::topMenu.item'
    )
)


//Aby zadziałało dla itemów należy nadac wszystkim ...
foreach (Menu::topMenu()->all() as $index => $item) {

    Menu::topMenu()->at($index)->setTemplate("menu::topMenu.item");

}

```


Ustawianie aktywnej / otwartej pozycji
______________

Wywołanie setActivePath powoduje przeszukanie rekurencyjne wszystkich pozycji i ich potomków i zaznaczenie wszystkich znalezionych w ścieżce na active / open
Działa poprawnie tylko jeśli ID wszystkich pozycji są unikalne.

```php
Menu::leftMenu()->setActivePath('idPozycji');
```