@foreach ($menuCollection[0]->all() as $menuItem)

<li class="{{-- $root['style'] --}}">


    {{$menuItem}}


    @if ($menuItem->hasChildren())

        <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer {{ $menuItem->getChildrenClass() }}">


                {{$menuItem->getChildren()}}


        </ul>

    @endif


</li>


@endforeach