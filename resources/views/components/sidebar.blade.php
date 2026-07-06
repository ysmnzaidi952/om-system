<!-- C:\laragon\www\om_system\resources\views\components\sidebar.blade.php -->
<!-- Reusable Sidebar Component -->
<aside class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="admin-info">
            <h3>{{ ucfirst(Auth::user()->role === 'superadmin' ? 'Admin' : Auth::user()->role) }} Dashboard</h3>
            <p>Welcome, <span>{{ Auth::user()->name }}</span></p>
        </div>
    </div>
    <nav class="sidebar-menu">
        <ul>
            {{-- 1. Dashboard --}}
            <li class="{{ request()->routeIs(Auth::user()->dashboard_route) ? 'active' : '' }}">
                <a href="{{ route(Auth::user()->dashboard_route) }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- 2. My Profile --}}
            <li class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <a href="{{ route('profile.show') }}">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>

            {{-- 3. Admin/Superadmin Only: Account Approval --}}
            @if(Auth::user()->canAccessAdmin())
            <li class="{{ request()->routeIs('admin.pending-staff') ? 'active' : '' }}">
                <a href="{{ route('admin.pending-staff') }}">
                    <i class="fas fa-user-clock"></i>
                    <span>Account Approval</span>
                </a>
            </li>
            @endif

            {{-- 4. Admin/Superadmin Only: All Staff --}}
            @if(Auth::user()->canAccessAdmin())
            <li class="{{ request()->routeIs('admin.all-staff') || request()->routeIs('admin.view-staff') || request()->routeIs('admin.edit-staff') ? 'active' : '' }}">
                <a href="{{ route('admin.all-staff') }}">
                    <i class="fas fa-users"></i>
                    <span>All Staff</span>
                </a>
            </li>
            @endif

            {{-- 5. Team Staff (All Roles) --}}
            <li class="{{ request()->routeIs(Auth::user()->team_staff_route) ? 'active' : '' }}">
                <a href="{{ route(Auth::user()->team_staff_route) }}">
                    <i class="fas fa-sitemap"></i>
                    <span>Team Staff</span>
                </a>
            </li>

            {{-- 6. Admin/Superadmin Only: Leave Management --}}
            @if(Auth::user()->canAccessAdmin())
            <li class="{{ request()->routeIs('admin.leave.*') ? 'active' : '' }}">
                <a href="{{ route('admin.leave.index') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Leave Management</span>
                </a>
            </li>
            @endif

            {{-- 7. My Leave (All Roles) --}}
            <li class="{{ request()->routeIs('leave.*') && !request()->routeIs('admin.leave.*') ? 'active' : '' }}">
                <a href="{{ route('leave.index') }}">
                    <i class="fas fa-umbrella-beach"></i>
                    <span>My Leave</span>
                </a>
            </li>

            {{-- 8. Calendar (All Roles) --}}
            <li class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <a href="{{ route('calendar.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Calendar</span>
                </a>
            </li>

            {{-- 9. Staff Birthday (All Roles) --}}
            <li class="{{ request()->routeIs('birthdays.*') ? 'active' : '' }}">
                <a href="{{ route('birthdays.index') }}">
                    <i class="fas fa-gift"></i>
                    <span>Staff Birthday</span>
                </a>
            </li>

            {{-- 10. Logout --}}
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</aside>
