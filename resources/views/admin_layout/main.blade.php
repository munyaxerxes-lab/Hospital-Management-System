<!-- Main Content Wrapper Shell Layout Framework -->
<main class="main-content">

  <!-- Top Header Navigation Dashboard Area -->
  <header class="topbar">

    <!-- Hamburger Menu Button (mobile only) -->
    <button class="hamburger-btn" id="sidebarToggle" aria-label="Toggle navigation menu" aria-expanded="false">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
    </button>

    <div class="topbar-search-wrapper">
        <!-- <div class="search-input-group">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" class="topbar-searchbar" placeholder="Search patients, doctors, tests..." id="globalAdminSearch">
            <span class="search-shortcut-badge">⌘K</span>
        </div> -->
    </div>
   
    <!-- Top Header Nav Inline Actions Context -->
    <div class="header-nav">
        
        <!-- Live System Status Badge -->
        <!-- <div class="system-status-indicator" title="All hospital services operational">
            <span class="status-pulse-dot"></span>
            <span class="status-pulse-text">System Live</span>
        </div> -->

        <!-- User Profile Dropdown Drop-panel Menu Anchor Frame -->
        <div class="user-dropdown-container">
            
            <!-- Clickable Interactive Target Trigger Wrap -->
            <div class="profile-trigger" id="dropdownTrigger" tabindex="0">
               
                <!-- Circular Avatar Initials Graphic Indicator -->
                <div class="user-avatar-badge">
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
                            AD
                        @endif
                    </span>
                </div>
                
                <div class="profile-text-wrap">
                    <span class="profile-user-name">
                        {{ Auth::check() ? Auth::user()->name : 'Administrator' }}
                    </span>
                    <span class="profile-user-role">Hospital Admin</span>
                </div>
                <i class="fa-solid fa-chevron-down chev"></i>
            </div>

            <!-- Floating Overlay Dropdown Nav Options Menu Element -->
            <div id="userDropdownMenu" class="dropdown-menu">
                
                <!-- User Header Summary -->
                <div class="dropdown-user-header">
                    <span class="dropdown-user-name">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</span>
                    <span class="dropdown-user-email">{{ Auth::check() ? Auth::user()->email : 'admin@medilink.com' }}</span>
                </div>

                <!-- Navigation Links -->
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
               
                <a href="{{ route('admin.profile.settings') }}" class="dropdown-item">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Account Settings</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- Session Termination Invalidation Form Pipeline element -->
                <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
  </header>

  <!-- Delete Account Confirmation Modal -->
  <div id="delete-account-modal" popover class="alert-modal-box">
    <div class="alert-modal-content">
      <div class="alert-modal-icon">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <h3 class="alert-modal-title">Delete Administrator Account</h3>
      <p class="alert-modal-desc">
        Are you sure you want to permanently delete your account? This will remove all your administrator privileges and erase your profile data from the system.
      </p>
      <div class="alert-modal-box-warning">
        <strong>Irreversible Action:</strong> Once confirmed, this account cannot be recovered.
      </div>
      <div class="alert-modal-actions">
        <button type="button" popovertarget="delete-account-modal" popovertargetaction="hide" class="btn-modal-cancel">
          Cancel
        </button>
        <form action="{{ route('account.delete') }}" method="POST" style="margin: 0;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn-modal-danger">
            <i class="fa-solid fa-trash"></i> Yes, Delete Account
          </button>
        </form>
      </div>
    </div>
  </div>
    
  <!-- Core Layout Content View Yield Nodes -->
  <section class="content">
      @yield('content')
      @yield('scripts')
  </section>

  <!-- Clean Admin Minimal Footer -->
  <footer class="admin-footer">
    <div class="admin-footer-content">
      <div class="admin-footer-left">
        <span>&copy; {{ date('Y') }} <strong>MediLink Hospital Management System</strong>. All rights reserved.</span>
      </div>
    </div>
  </footer>

</main>

<!-- Sidebar Overlay Backdrop (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Vanilla JS Event Interface Logic Bindings -->
<script>
  // Profile dropdown
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

  // Hamburger / Sidebar drawer toggle
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const asideEl = document.querySelector('.aside');

  function openSidebar() {
      asideEl && asideEl.classList.add('drawer-open');
      sidebarOverlay && sidebarOverlay.classList.add('active');
      sidebarToggle && sidebarToggle.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
      asideEl && asideEl.classList.remove('drawer-open');
      sidebarOverlay && sidebarOverlay.classList.remove('active');
      sidebarToggle && sidebarToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
  }

  if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          const isOpen = asideEl && asideEl.classList.contains('drawer-open');
          isOpen ? closeSidebar() : openSidebar();
      });
  }

  if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', closeSidebar);
  }

  // Close sidebar on nav item click (mobile)
  document.querySelectorAll('.sidebar .nav-item').forEach(function(item) {
      item.addEventListener('click', function() {
          if (window.innerWidth <= 768) closeSidebar();
      });
  });

  // Close sidebar on ESC key
  document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeSidebar();
  });
</script>
