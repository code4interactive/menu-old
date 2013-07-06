<?php $menuItem = $menuItem[0]; ?>

@if ($menuItem->getType() == 'subHeader')

<li class="{{$menuItem->getClass()}} nav-header">

    @if ($menuItem->getIcon())
    <i class="{{ $menuItem->getIcon() }}"></i>
    @endif

    {{ $menuItem->getName() }}

    @else

<li class="{{$menuItem->getClass()}}">
    @if ($menuItem->hasChildren())

        <a class="dropdown-toggle" href="{{ $menuItem->getUrl() }}">

    @else

        <a href="{{ $menuItem->getUrl() }}">

    @endif


            @if ($menuItem->getLvl() == 0)

                @if ($menuItem->getIcon())
                    <i class="{{ $menuItem->getIcon() }}"></i>
                @endif

                <span>{{ $menuItem->getName() }}</span>

            @else

                @if ($menuItem->getIcon())
                    <i class="{{ $menuItem->getIcon() }}"></i>
                @endif

                {{ $menuItem->getName() }}

            @endif

            @if ($menuItem->hasChildren())
                <b class="arrow icon-angle-down"></b>
            @endif

        </a>
        @endif

        @if ($menuItem->hasChildren())

        <ul class="submenu {{ $menuItem->getChildrenClass() }}">

            {{$menuItem->getChildren()}}

        </ul>

        @endif


</li>

