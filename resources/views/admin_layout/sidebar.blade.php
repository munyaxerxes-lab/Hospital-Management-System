<!-- Sidebar -->
<aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('image/logo1.png') }}" alt="MediLink Logo" class="logo-image">
        <div class="ad"><h3>Admin</h3>
        <p class="logo-text">SYSTEM</p></div>
    </div>

    <!-- Navigation -->
    <nav class="navigation">

        <a href="/admin_dashboard" class="nav-item active">
            <i class="ri-home-4-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="/appointment_request" class="nav-item">
            <i class="ri-calendar-line"></i>
            <span>Appointments Request</span>
        </a>

        <a href="/lab_request" class="nav-item">
            <i class="ri-time-line"></i>
            <span>Lab Requests</span>
        </a>

         <a href="/medicine_orders" class="nav-item">
             <i class="ri-time-line"></i>
           <span>Medicine Orders</span>

        <a href="/manage_doctors" class="nav-item">
             <i class="ri-account-circle-line"></i>
           <span> Manage Doctors</span>
        </a>

       
       

    </nav>

    <!-- Logout -->
    <div class="logout-container">
        <a href="/Logout" class="logout">
            <i class="ri-logout-box-r-line"></i>
            <span>Logout</span>
        </a>
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

    navItems.forEach(function (item) {
        const href = item.getAttribute('href');

        if (!href || href === '#') {
            return;
        }

        const hrefPath = new URL(href, window.location.origin).pathname.toLowerCase();

        if (currentPath === hrefPath) {
            matchedItem = item;
        }
    });

    if (matchedItem) {
        setActiveItem(matchedItem);
    } else {
        const existingActive = document.querySelector('.nav-item.active');
        if (existingActive) {
            setActiveItem(existingActive);
        }
    }
});

</script>