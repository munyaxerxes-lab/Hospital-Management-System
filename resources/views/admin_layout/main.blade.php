<!-- Main Content Wrapper Shell Layout Framework -->
<main class="main-content">

  <!-- Top Header Navigation Dashboard Area -->
  <header class="topbar">
    <div class="doctors-tools">
        <input class="searchbar" placeholder="Search ...."
        style="width: 20rem;
        height: 2rem;
        border-radius: 12px;
        border: 1px solid blue;
        padding-left: 1rem"
        >
    </div>
   
    <!-- Top Header Nav Inline Actions Context -->
    <div class="header-nav" style="display: flex; justify-content: flex-end; align-items: center; padding: 15px; position: relative;">
        
        <!-- User Profile Dropdown Drop-panel Menu Anchor Frame -->
        <div class="user-dropdown-container" style="position: relative; display: inline-block;">
            
            <!-- Clickable Interactive Target Trigger Wrap -->
            <div class="profile-trigger" id="dropdownTrigger" tabindex="0"
                 style="display: flex; gap: 0.5rem; align-items: center; cursor: pointer; user-select: none;">
               
                <!-- Circular Avatar Initials Graphic Indicator -->
                <div style="
                    border: none;
                    border-radius: 50%;
                    width: 2.5rem;
                    height: 2.5rem;
                    align-items: center;
                    background: #164dad;
                    color: white;
                    font-size: 14px;
                    font-weight: bold;
                    display: flex;
                    justify-content: center;
                    ">
                    <span class="user-initials">
                        @if(Auth::check())
                            @php
                                $words = explode(' ', Auth::user()->name);
                                $extractedInitials = '';
                                foreach ($words as $w) {
                                    $extractedInitials .= mb_substr($w, 0, 1);
                                }
                                echo strtoupper(mb_substr($extractedInitials, 0, 2));
                            @endphp
                        @else
                            U
                        @endif
                    </span>
                </div>
                
                
                <span style="font-weight: 500; color: #333;">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <i class="fa-solid fa-chevron-down chev" style="font-size: 12px; color: #666; transition: transform 0.2s;"></i>
            </div>

            <!-- Floating Overlay Dropdown Nav Options Menu Element -->
            <div id="userDropdownMenu" class="dropdown-menu">
                
                <!-- Home Dashboard Dynamic Redirection Check link -->
                @if(Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin')
                    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                @else
                    <a href="{{ route('patient.dashboard') }}">📊 Dashboard</a>
                @endif
               
                <!-- Interactive Operational Settings Form Redirection Panel link -->
                @if(Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin')
                    <a href="{{ route('admin.profile.settings') }}">⚙️ Settings</a>
                @else
                    <a href="{{ route('profile.settings') }}">⚙️ Settings</a>
                @endif

                <!-- Account Deletion Action Execution Form Pipeline element -->
                <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete your account?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item delete-btn">⚠️ Delete Account</button>
                </form>

                <hr style="margin: 4px 0; border: 0; border-top: 1px solid #eee;">

                <!-- Session Termination Invalidation Form Pipeline element -->
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">🚪 Log Out</button>
                </form>
            </div>

        </div>
    </div>
  </header>
    
  <!-- Core Layout Content View Yield Nodes -->
  <section class="content">
      @yield('content')
      @yield('scripts')
  </section>

</main>

<!-- Vanilla JS Event Interface Logic Bindings -->
<script>
  document.getElementById('dropdownTrigger').addEventListener('click', function(event) {
      event.stopPropagation();
      const menu = document.getElementById('userDropdownMenu');
      menu.classList.toggle('show');
  });

  window.addEventListener('click', function(event) {
      const menu = document.getElementById('userDropdownMenu');
      if (menu && menu.classList.contains('show')) {
          menu.classList.remove('show');
      }
  });
</script>
