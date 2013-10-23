<aside id="sidebar">
    <nav id="navigation" class="collapse">
        <ul>
            @foreach($menu->getRootItems() as $rootItem)
            <li {{ $menu->activeClass($rootItem) }}>
                <span title="{{ $rootItem->getTitle() }}">
                    {{ $rootItem->getIcon() }}
                    <span class="nav-title" {{ $rootItem->hasAlerts() ? 'style="color:#F00"' : '' }}>
                        {{ $rootItem->getTitle() }}
                        @if($rootItem->hasAlerts())
                        <span>({{ $rootItem->countAlerts() }})</span>
                        @endif
                    </span>
                </span>

                <ul class="inner-nav">
                    @foreach($rootItem->getChildren() as $childItem)
                    <li {{ $menu->activeClass($childItem) }}>
                        <a href="{{ freakUrl($childItem->getUri()) }}">
                            {{ $childItem->getIcon() }}
                            {{ $childItem->getTitle() }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </nav>
</aside>