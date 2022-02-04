<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}">
            <span class="align-middle">{{$app_name}}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                home
            </li>
            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('home') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-header">
                Main Content
            </li>
            <li class="sidebar-item {{ request()->routeIs('category.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('category.index') }}">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Category</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('sub-category.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sub-category.index') }}">
                    <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Sub-Category</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('item.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('item.index') }}">
                    <i class="align-middle" data-feather="file"></i> <span class="align-middle">Item</span>
                </a>
            </li>
            <li class="sidebar-header">
                setting
            </li>

            <li class="sidebar-item {{ request()->routeIs('setting.index') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('setting.index') }}">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting</span>
                </a>
            </li>

            <li class="sidebar-header">
                admin
            </li>
           
        </ul>
    </div>
</nav>