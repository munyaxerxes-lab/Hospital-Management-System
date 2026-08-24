<!-- Main Content -->
<main class="main-content">

  <!-- Top Header -->
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
   
    <!-- Top Header Nav Wrapper -->
    <div class="header-nav" style="display: flex; justify-content: flex-end; align-items: center; padding: 15px; position: relative;">
        
        <!-- User Profile Dropdown Container -->
        <div class="user-dropdown-container" style="position: relative; display: inline-block;">
            
            <!-- Clickable Profile Trigger Wrap -->
            <div class="profile-trigger" id="dropdownTrigger" tabindex="0"
                 style="display: flex; gap: 0.5rem; align-items: center; cursor: pointer; user-select: none;">
               
                <!-- Circular Avatar Initials Indicator -->
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
                
                <!-- Concatenated Username and Icon Arrow -->
                <span style="font-weight: 500; color: #333;">
                    {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                </span>
                <i class="fa-solid fa-chevron-down chev" style="font-size: 12px; color: #666; transition: transform 0.2s;"></i>
            </div>

            <!-- 🌟 Floating Dropdown Menu Panel -->
            <div id="userDropdownMenu" class="dropdown-menu">
                <a href="{{ route('user.dashboard') }}">📊 Dashboard</a>
                
                <!-- Account Deletion Action Form Wrapper -->
                <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete your account?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item delete-btn">⚠️ Delete Account</button>
                </form>

                <hr style="margin: 4px 0; border: 0; border-top: 1px solid #eee;">

                <!-- Logout Form Wrapper -->
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <!-- 🌟 FIXED: Removed broken text '@button' syntax directive right here -->
                    <button type="submit" class="dropdown-item logout-btn">🚪 Log Out</button>
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

<!-- 🌟 Essential Dropdown Presentation Styles -->
<style>
  .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 115%;
      background-color: #ffffff;
      min-width: 200px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.12);
      border-radius: 8px;
      padding: 6px 0;
      z-index: 1000;
      border: 1px solid #eef0f6;
  }

  .dropdown-menu.show {
      display: block;
  }

  .dropdown-item {
      display: block;
      width: 100%;
      padding: 10px 16px;
      text-align: left;
      background: none;
      border: none;
      color: #333333;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
      box-sizing: border-box;
      font-family: inherit;
  }

  .dropdown-menu a {
      text-decoration: none;
      color: #333333;
      display: block;
      padding: 10px 16px;
      font-size: 14px;
  }

  .dropdown-menu a:hover, .dropdown-item:hover {
      background-color: #f4f6f9;
  }

  .dropdown-menu .delete-btn {
      color: #dc3545;
  }

  .dropdown-menu .logout-btn {
      color: #164dad;
      font-weight: 500;
  }
</style>

<!-- JavaScript Handler logic -->
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
