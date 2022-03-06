<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}">
            <span class="align-middle">{{$app_name}}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Home
            </li>
            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('home') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-header">
                Main Content
            </li>
            @can('view category')
            <li class="sidebar-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('category.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Category</span>
                </a>
            </li>
            @endcan
            @can('view sub-category')
            <li class="sidebar-item {{ request()->routeIs('sub-category.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sub-category.index') }}">
                    <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Sub-Category</span>
                </a>
            </li>
            @endcan
            @can("view item")
            <li class="sidebar-item {{ request()->routeIs('item.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('item.index') }}">
                    <i class="align-middle" data-feather="file"></i> <span class="align-middle">Item</span>
                </a>
            </li>
            @endcan

            <li class="sidebar-header">
                Setting
            </li>
            @can('view setting')
            <li class="sidebar-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('setting.index') }}">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting</span>
                </a>
            </li>
            @endcan
            <li class="sidebar-header">
                Admin
            </li>
            @can('view role')
            <li class="sidebar-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('role.index') }}">
                    <i class="align-middle" data-feather="check"></i> <span class="align-middle">Role</span>
                </a>
            </li>
            @endcan
            @can('view admin')
            <li class="sidebar-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('user.index') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Admin</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</nav>