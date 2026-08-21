<!-- Main Content -->
<main class="main-content">

    <!-- Top Header -->
    <header class="top-header">

         <div class="user-section">
            <a href="/check notification">
                <button class="notification-button">
                    <i class="fas fa-bell"></i>
                </button>
            </a>
             <span class="user-name" style="background-color: none; border: 1px solid #ccc; border-radius: 50%; width: 3rem; height: 3rem; padding: 3px 6px 9px;">
                {{ Str::of(Auth::user()->name)->headline()->explode(' ')->map(fn($word) => Str::substr($word, 0, 1))->take(2)->implode('') }}
             </span>
             <div class="profile-img">
               
            </div>

        </div>

    </header>

    <!-- Page Content -->
    <section class="content">
        
        
        @yield('content')
        @yield('scripts')
    </section>

</main>