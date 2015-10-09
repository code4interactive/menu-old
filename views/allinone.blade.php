@foreach($items as $item)
    <li {!! $item->attributes() !!}>
        <a href="{{ $item->url() }}">{!! $item->icon !!}<span class="nav-label">{!! $item->title !!}</span> @if($item->hasChildren())<span class="fa arrow"></span>@endif</a>
        @if($item->hasChildren())
            <ul class="nav nav-second-level collapse">
                @foreach($item->children() as $second)
                    <li {!! $second->attributes() !!}>
                        <a href="{{ $second->url() }}">{!! $second->icon !!}{{ $second->title }}@if($second->hasChildren())<span class="fa arrow"></span>@endif</a>
                        @if($second->hasChildren())
                            <ul class="nav nav-third-level collapse">
                                @foreach($second->children() as $third)
                                    <li {!! $third->attributes() !!}><a href="{{ $third->url() }}">{{ $third->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach