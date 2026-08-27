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

        <a href="/dashboard" class="nav-item active">
            <i class="ri-home-4-line"></i>
            <span>Dashboard</span>
        </a>

        <a href="/appointments" class="nav-item">
            <i class="ri-calendar-line"></i>
            <span>Appointments</span>
        </a>

        <a href="/labtests" class="nav-item">
            <i class="ri-flask-line"></i>
            <span>Lab Tests</span>
        </a>

        <a href="/pharmacy" class="nav-item">
            <i class="ri-calendar-2-line"></i>
            <span>Pharmacy</span>
        </a>

        <a href="/history" class="nav-item">
            <i class="ri-time-line"></i>
            <span>History</span>
        </a>

        @php
            $liveCartCount = isset($cartCount) ? $cartCount : (auth()->check() ? \App\Models\cart::where('user_id', auth()->id())->sum('quantity') : 0);
        @endphp
        <a href="/cart" class="nav-item" style="display:flex;align-items:center;position:relative;">
            <i class="ri-shopping-cart-line"></i>
            <span>Cart</span>
            <span class="cart-badge-pill" id="sidebarCartBadge" style="background:#ef4444;color:#ffffff;font-size:11px;font-weight:700;padding:2px 7px;border-radius:99px;margin-left:auto;{{ $liveCartCount > 0 ? 'display:inline-block;' : 'display:none;' }}">
                {{ $liveCartCount }}
            </span>
        </a>

        <!-- Active Navigation -->
       

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