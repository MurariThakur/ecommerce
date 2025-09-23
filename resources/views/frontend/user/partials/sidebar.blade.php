<div class="account-sidebar">
    <div class="user-info">
        <div class="user-avatar">
            <i class="icon-user"></i>
        </div>
        <div class="user-details">
            <h4>{{ Auth::user()->name }}</h4>
            <p>{{ Auth::user()->email }}</p>
        </div>
    </div>
    
    <nav class="account-nav">
        <ul>
            <li class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <a href="{{ route('user.dashboard') }}">
                    <i class="icon-home-3"></i>
                    Dashboard
                </a>
            </li>
            <li class="{{ request()->routeIs('user.orders*') ? 'active' : '' }}">
                <a href="{{ route('user.orders') }}">
                    <i class="icon-bag-2"></i>
                    My Orders
                </a>
            </li>
            <li class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <a href="{{ route('user.profile') }}">
                    <i class="icon-user"></i>
                    Profile
                </a>
            </li>
            <li class="{{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                <a href="{{ route('user.change-password') }}">
                    <i class="icon-lock"></i>
                    Change Password
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>