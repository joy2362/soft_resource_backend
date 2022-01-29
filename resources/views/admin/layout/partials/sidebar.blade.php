<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}">
            <span class="align-middle">Soft Resource</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('home') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
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
        </ul>
    </div>
</nav>