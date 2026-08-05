<!-- Sidebar -->
<aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <img src="{{ asset('image/logo1.png') }}" alt="MediLink Logo" class="logo-image">
        <div><h2>Medi<span>Link</span></h2>
        <p class="logo-text">Health Services</p></div>
    </div>

    <!-- Navigation -->
    <nav class="navigation">

        <a href="/home" class="nav-item active">
            <i class="ri-home-4-line"></i>
            <span>Home</span>
        </a>

        <a href="/appointment" class="nav-item">
            <i class="ri-calendar-line"></i>
            <span>Appointments</span>
        </a>

        <a href="/availability" class="nav-item">
            <i class="ri-time-line"></i>
            <span>Availability</span>
        </a>

        <a href="/consultation" class="nav-item">
            <i class="ri-calendar-2-line"></i>
           <span>Consultation History</span>
        </a>

        <a href="/profile" class="nav-item">
           <i class="ri-account-circle-line"></i>
           <span>Profile</span>
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