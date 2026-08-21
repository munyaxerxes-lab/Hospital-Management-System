<!-- Main Content -->
<main class="main-content">

         <!-- Top Header -->
  <header class="topbar">
    <div class="doctors-tools">
        <input class="searchbar" placeholder="Search ...."
        style="width: 20rem;
        height: 2rem;
        border-radius: 12px;
        border: 1px solid gray;
        padding-left: 1rem"
        >
       
    </div>
    <div class="admin-user">
        <div class="admin-avatar"><i class="fa-solid fa-user"></i></div>
        <span>                {{ Str::of(Auth::user()->name)->headline()->explode(' ')->map(fn($word) => Str::substr($word, 0, 1))->take(2)->implode('') }}
</span><i class="fa-solid fa-chevron-down chev"></i>
    </div>
</header>
    
    <!-- Page Content -->
    <section class="content">
        
        
        @yield('content')
        @yield('scripts')
    </section>

</main>