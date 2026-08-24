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
          <!-- Top Header Nav Wrapper -->
<div class="header-nav" style="display: flex; justify-content: flex-end; align-items: center; padding: 15px; position: relative;">
    
    <!-- User Profile Dropdown Container -->
    <div class="user-dropdown-container">
        
        <!-- The Circular Trigger Area -->
        <div class="profile-trigger" tabindex="0">
           <!-- The Circular Trigger Area -->
        <div class="profile-trigger" tabindex="0">
                            <span class="user-initials">
                                @if(Auth::check())
                                    @php
                                        // Extract first letters/acronyms of their names straight from the session
                                        $words = explode(' ', Auth::user()->name);
                                        $extractedInitials = '';
                                        foreach ($words as $w) {
                                            $extractedInitials .= mb_substr($w, 0, 1);
                                        }
                                        echo strtoupper(mb_substr($extractedInitials, 0, 2));
                                    @endphp
                                @else
                                    U<!-- Fallback character "U" for Guest/User if not logged in -->
                                @endif
                            </span>
        </div>
    </div>

        <!-- The Floating Dropdown Menu Panel -->
        <div class="dropdown-menu-panel">
            <div class="dropdown-user-info">
                <strong>{{ auth()->user()?->name }}</strong>

                <p>{{ auth()->user()?->email }}</p>
            </div>
            
            <hr class="dropdown-divider">
            
            <!-- Secure Delete Action Inside the Menu Container -->
            <form 
                action="{{ route('account.delete') }}" method="POST" class="dropdown-action-form" onsubmit="return confirm
                ('⚠️ Are you absolutely sure you want to permanently delete your account? This action cannot be undone.');">
                @csrf
                <button type="submit" class="btn-dropdown-delete">
                    Delete Account Permanently ⚠️
                </button>
            </form>
            
            <!-- Secure Logout Option Inside Menu -->
            <form action="{{ route('logout') }}" method="POST" class="dropdown-action-form">
                @csrf
                <button type="submit" class="btn-dropdown-logout">
                    Log Out 🚪
                </button>
            </form>
        </div>

    </div>
</div>
</header>
    
    <!-- Page Content -->
    <section class="content">
        
        
        @yield('content')
        @yield('scripts')
    </section>

</main>