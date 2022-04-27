<div class="bg-slate-800 flex-grow text-white">
    <ul id="navbar" data-current-page={{$current_nav_page}}>
        <a href="{{ route('dashboard') }}">
            <li id="dashboard_link" class="p-2 pl-3 border-b border-blue-500 hover:bg-blue-200 hover:text-black select-none">
                {{__('Dashboard')}}
            </li>
        </a>
        <a href="{{ route('pages') }}">
            <li id="pages_link" class="p-2 pl-3 border-b border-blue-500 hover:bg-blue-200 hover:text-black select-none">
                {{__('Pages')}}
            </li>
        </a>
        <a href="{{ route('navigation') }}">
            <li id="navigation_link" class="p-2 pl-3 border-b border-blue-500 hover:bg-blue-200 hover:text-black select-none">
                {{__('Navigation')}}
            </li>
        </a>
        <a href="{{ route('users') }}">
            <li id="users_link" class="p-2 pl-3 border-b border-blue-500 hover:bg-blue-200 hover:text-black select-none">
                {{__('Users')}}
            </li>
        </a>
        <a href="{{ route('roles') }}">
            <li id="roles_link" class="p-2 pl-3 border-b border-blue-500 hover:bg-blue-200 hover:text-black select-none">
                {{__('Roles')}}
            </li>
        </a>
    </ul>
</div>

<script>
    let currentPage = document.getElementById('navbar').dataset.currentPage;
    document.getElementById(currentPage + '_link').classList.add('bg-blue-500');
</script>