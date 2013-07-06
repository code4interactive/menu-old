<a data-toggle="dropdown" class="dropdown-toggle" href="#">
    @if ($menuItem[0]->getIcon())
    <i class="{{ $menuItem[0]->getIcon() }}"></i>
    @endif
    {{ $menuItem[0]->getName() }}
</a>