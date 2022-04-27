<div class="flex-box-h">
    <ul id="navbar" class="navigation-list">
        @foreach ($navigation_items as $item)
            <li>
                <a id="" href="{{ $item->href }}">{{ $item->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
