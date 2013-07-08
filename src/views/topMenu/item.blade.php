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
        <a data-toggle="dropdown" class="dropdown-toggle" href="{{ $menuItem->getUrl() }}">
    @else
        <a href="{{ $menuItem->getUrl() }}">
    @endif


    @if ($menuItem->getLvl() == 0)

        @if ($menuItem->getIcon())
            <i class="{{ $menuItem->getIcon() }}"></i>
        @endif

        {{ $menuItem->getName() }}

    @else

        <div class="clearfix">
            <span class="pull-left">
                @if ($menuItem->getIcon())
                    <i class="btn btn-mini no-hover {{ $menuItem->getIcon() }}"></i>
                @endif

                {{ $menuItem->getName() }}

            </span>
        </div>

    @endif

    </a>
@endif

@if ($menuItem->hasChildren())

    <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer {{ $menuItem->getChildrenClass() }}">

        {{$menuItem->getChildren()}}

    </ul>

@endif


    </li>

