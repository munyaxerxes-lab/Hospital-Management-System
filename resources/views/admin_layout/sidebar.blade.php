<!-- Sidebar -->
<aside class="sidebar">

    <!-- Logo & Brand Header -->
    <div class="logo">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <img class="brand-logo" src="{{ asset('image/logo1.png') }}" alt="MediLink Logo">
            <div class="brand-info">
                <div class="brand-name">Medi<span>Link</span></div>
                <span class="brand-badge">ADMIN PORTAL</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="navigation">
        <div class="nav-section-label">MAIN NAVIGATION</div>

        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ (request()->is('admin_dashboard*') || request()->is('admin/dashboard*') || request()->is('admin')) ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-solid fa-chart-pie"></i></div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.appointments.index') }}" class="nav-item {{ (request()->is('appointment_request*') || request()->is('admin/appointments*') || request()->is('admin/appointment*')) ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-regular fa-calendar-check"></i></div>
            <span>Appointments</span>
        </a>

        <a href="{{ route('admin.lab_tests.index') }}" class="nav-item {{ (request()->is('lab_request*') || request()->is('admin/lab*')) ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-solid fa-flask-vial"></i></div>
            <span>Laboratory</span>
        </a>

        <a href="{{ route('admin.medicines.index') }}" class="nav-item {{ (request()->is('medicine_orders*') || request()->is('admin/medicines*') || request()->is('admin/medicine*')) ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
            <span>Pharmacy</span>
        </a>

        <a href="{{ route('admin.doctors.index') }}" class="nav-item {{ (request()->is('manage_doctors*') || request()->is('admin/doctors*') || request()->is('admin/doctor*')) ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-solid fa-user-doctor"></i></div>
            <span>Doctors</span>
        </a>

        <div class="nav-section-label" style="margin-top: 18px;">SETTINGS & SECURITY</div>

        <a href="{{ route('admin.profile.settings') }}" class="nav-item {{ request()->is('admin/profile*') ? 'active' : '' }}">
            <div class="nav-icon-box"><i class="fa-solid fa-sliders"></i></div>
            <span>Account Settings</span>
        </a>
    </nav>

    <!-- Logout Button Container -->
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
            @csrf
            <button type="submit" class="btn-sidebar-logout" title="Sign out of your administrator account">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
  
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.nav-item');

    function setActiveItem(targetItem) {
        navItems.forEach(function (item) {
            item.classList.remove('active');
        });

        if (targetItem) {
            targetItem.classList.add('active');
        }
    }

    navItems.forEach(function (item) {
        item.addEventListener('click', function () {
            setActiveItem(this);
        });
    });

    const currentPath = window.location.pathname.toLowerCase();
    let matchedItem = null;

    // Check exact or prefix match
    navItems.forEach(function (item) {
        const href = item.getAttribute('href');

        if (!href || href === '#') {
            return;
        }

        const hrefPath = new URL(href, window.location.origin).pathname.toLowerCase();

        if (currentPath === hrefPath) {
            matchedItem = item;
        } else if (
            (hrefPath.includes('appointment') && (currentPath.includes('appointment'))) ||
            (hrefPath.includes('doctor') && (currentPath.includes('doctor'))) ||
            (hrefPath.includes('lab') && (currentPath.includes('lab'))) ||
            (hrefPath.includes('medicine') && (currentPath.includes('medicine')))
        ) {
            matchedItem = item;
        }
    });

    if (matchedItem) {
        setActiveItem(matchedItem);
    }
});
</script>