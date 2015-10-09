
@foreach($items as $item)
    <li {!! $item->cAttributes() !!}>
        <a href="{{ $item->getUrl() }}">{!! $item->renderIcon() !!}<span class="nav-label">{!! $item->getTitle() !!}</span> @if($item->hasChildren())<span class="fa arrow"></span>@endif</a>
        @if($item->hasChildren())
            <ul class="nav nav-second-level collapse">
                @foreach($item->getChildren() as $second)
                    <li {!! $second->cAttributes() !!}>
                        <a href="{{ $second->getUrl() }}">{!! $second->renderIcon() !!}{{ $second->getTitle() }}@if($second->hasChildren())<span class="fa arrow"></span>@endif</a>
                        @if($second->hasChildren())
                            <ul class="nav nav-third-level collapse">
                                @foreach($second->getChildren() as $third)
                                    <li {!! $third->cAttributes() !!}><a href="{{ $third->getUrl() }}">{{ $third->getTitle() }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach