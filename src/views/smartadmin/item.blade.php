<?php $menuItem = $menuItem[0]; ?>

asdadasdasdasdasd

    <li class="{{$menuItem->getClass()}}">

        @if ($menuItem->getLvl() == 0)
            <a href="#"><i class="fa fa-lg fa-fw {{ $menuItem->getIcon() }}"></i> <span class="menu-item-parent">{{ $menuItem->getName() }}</span></a>
        @else
            <a href="#"><i class="fa fa-fw {{ $menuItem->getIcon() }}"></i> {{ $menuItem->getName() }}</a>
        @endif

        @if ($menuItem->hasChildren())
        <ul>
            {{$menuItem->getChildren()}}
        </ul>
        @endif;
    </li>


