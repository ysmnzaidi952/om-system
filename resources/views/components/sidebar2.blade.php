<!-- C:\laragon\www\om_system\resources\views\components\sidebar2.blade.php -->
<aside class="dashboard-sidebar">

    <div class="sidebar-header">
        <div class="sidebar-brand">O&amp;M</div>
        <div class="sidebar-role">{{ ucfirst(Auth::user()->role === 'superadmin' ? 'Admin' : Auth::user()->role) }} Dashboard</div>
        <div class="sidebar-user">{{ Auth::user()->name }}</div>
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
            <li class="sidebar-logout">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

</aside>

<style>
/* ============================================================
   SIDEBAR2 — styles scoped to .dashboard-sidebar
   ============================================================ */

.dashboard-sidebar {
    width: 240px;
    min-height: 100vh;
    background: #042e2c;
    border-right: 1px solid rgba(255,255,255,0.06);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}

/* ── Header ── */
.sidebar-header {
    padding: 32px 24px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.sidebar-brand {
    font-family: var(--font, 'Poppins', sans-serif);
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 3px;
    color: var(--accent, #0EA5A0);
    line-height: 1;
    margin-bottom: 10px;
}

.sidebar-role {
    font-size: 10px;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: rgba(245,243,239,0.35);
    margin-bottom: 4px;
}

.sidebar-user {
    font-size: 13px;
    font-weight: 500;
    color: #ffffff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── Nav ── */
.sidebar-menu {
    flex: 1;
    padding: 16px 0;
}

.sidebar-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.sidebar-menu li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 24px;
    font-size: 13px;
    color: rgba(245,243,239,0.5);
    letter-spacing: 0.3px;
    transition: all 0.2s;
    position: relative;
    text-decoration: none;
}

.sidebar-menu li a i {
    font-size: 13px;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
    color: rgba(245,243,239,0.3);
    transition: color 0.2s;
}

/* Hover state */
.sidebar-menu li a:hover {
    color: #ffffff;
    background: rgba(14,165,160,0.08);
    padding-left: 28px;
}

.sidebar-menu li a:hover i {
    color: var(--accent, #0EA5A0);
}

/* Active state */
.sidebar-menu li.active a {
    color: #ffffff;
    background: rgba(14,165,160,0.14);
    font-weight: 500;
}

.sidebar-menu li.active a::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--accent, #0EA5A0);
    border-radius: 0 2px 2px 0;
}

.sidebar-menu li.active a i {
    color: var(--accent, #0EA5A0);
}

/* ── Logout ── */
.sidebar-logout {
    margin-top: auto;
    border-top: 1px solid rgba(255,255,255,0.06);
}

.sidebar-logout a {
    color: rgba(245,243,239,0.3) !important;
}

.sidebar-logout a:hover {
    color: #f87171 !important;
    background: rgba(239,68,68,0.08) !important;
    padding-left: 28px;
}

.sidebar-logout a:hover i {
    color: #f87171 !important;
}

/* ── Scrollbar ── */
.dashboard-sidebar::-webkit-scrollbar       { width: 4px; }
.dashboard-sidebar::-webkit-scrollbar-track { background: transparent; }
.dashboard-sidebar::-webkit-scrollbar-thumb {
    background: rgba(14,165,160,0.2);
    border-radius: 2px;
}
.dashboard-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(14,165,160,0.4);
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .dashboard-sidebar { width: 200px; }
}

@media (max-width: 768px) {
    .dashboard-sidebar {
        width: 100%;
        min-height: auto;
        height: auto;
        position: relative;
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .sidebar-menu ul {
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
        padding: 8px;
    }

    .sidebar-menu li {
        flex: 1;
        min-width: 80px;
    }

    .sidebar-menu li a {
        flex-direction: column;
        padding: 10px 8px;
        font-size: 10px;
        gap: 6px;
        text-align: center;
    }

    .sidebar-menu li a:hover {
        padding-left: 8px;
    }

    .sidebar-menu li.active a::before {
        top: 0; left: 0; right: 0; bottom: auto;
        width: auto;
        height: 2px;
    }

    .sidebar-logout {
        border-top: none;
    }
}
</style>
