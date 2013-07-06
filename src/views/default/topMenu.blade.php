@foreach ($menu['topmenu']['root'] as $lp=>$root)

<li class="{{ $root['style'] }}">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        @if ($root['icon'])
        <i class="{{ $root['icon'] }}"></i>
        @endif
        {{ $root['name'] }}
    </a>


    @if (key_exists($root['id'], $menu['topmenu']))

    <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer {{ isset($root['sub-style'])?($root['sub-style']):'' }}">

        @foreach ($menu['topmenu'][$root['id']] as $lp=>$sub)

        @if (key_exists('type', $sub) && $sub['type'] == 'sub-header')
        <li class="nav-header">
            @if ($sub['icon'])
            <i class="{{ $sub['icon'] }}"></i>
            @endif
            {{ $sub['name'] }}
        </li>

        @else

        <li>
            <a href="#">
                <div class="clearfix">
                    <span class="pull-left">
                        @if ($sub['icon'])
                            <i class="btn btn-mini no-hover {{ $sub['icon'] }}"></i>
                        @endif

                        {{ $sub['name'] }}
                    </span>
                </div>
            </a>
        </li>

        @endif

        @endforeach

    </ul>

    @endif



</li>

@endforeach