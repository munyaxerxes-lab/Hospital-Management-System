<!-- Main Content -->
<main class="main-content">

    <!-- Top Header -->
    <header class="top-header">


        <div class="user-section">
            <a href="/check notification">
                <button class="notification-button">
                    <i class="ri-notification-3-line"></i>
                </button>
            </a>

           
            <span class="user-name">Hello, sarah</span>
             <div class="profile-img">
                <img src="/image/doc.png" alt="User Profile">
            </div>
        </div>

    </header>

    <!-- Page Content -->
    <section class="content">
        
        
        @yield('content')
        @yield('scripts')
    </section>

</main>