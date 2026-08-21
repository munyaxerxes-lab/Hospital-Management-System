<!-- Main Content -->
<main class="main-content">

    <!-- Top Header -->
  <header class="topbar">
    <div class="doctors-tools">
        <input class="search" placeholder="Search .................">
       
    </div>
    <div class="admin-user">
        <div class="admin-avatar"><i class="fa-solid fa-user"></i></div>
        <span>Administrator</span><i class="fa-solid fa-chevron-down chev"></i>
    </div>
</header>

    <!-- Page Content -->
    <section class="content">
        
        
        @yield('content')
        @yield('scripts')
    </section>

</main>
