<!-- Sidebar -->
<aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
       <div class="brand">
            <img class="brand-logo" src="{{ asset('image/logo1.png') }}" alt="Admin System Logo">
            <div class="brand-name">Admin<span>SYSTEM</span></div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navigation">

        <a href="/admin_dashboard" class="nav-item {{ (request()->is('admin_dashboard*') || request()->is('admin/dashboard*') || request()->is('admin')) ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="/appointment_request" class="nav-item {{ (request()->is('appointment_request*') || request()->is('admin/appointments*')) ? 'active' : '' }}">
            <i class="fa-regular fa-calendar"></i>
            <span>Appointments</span>
        </a>

        <a href="/lab_request" class="nav-item {{ (request()->is('lab_request*') || request()->is('admin/lab*')) ? 'active' : '' }}">
            <i class="fa-solid fa-flask"></i>
            <span>Laboratory</span>
        </a>

        <a href="/medicine_orders" class="nav-item {{ (request()->is('medicine_orders*') || request()->is('admin/medicines*')) ? 'active' : '' }}">
            <i class="fa-solid fa-capsules"></i>
            <span>Pharmacy</span>
        </a>

        <a href="/manage_doctors" class="nav-item {{ (request()->is('manage_doctors*') || request()->is('admin/doctors*')) ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i>
            <span>Doctors</span>
        </a>

    </nav>

    <!-- Logout Button -->
    <div class="logout-container">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
            @csrf
            <button type="submit" class="btn-sidebar-logout" title="Sign out of your administrator account">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Logout</span>
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