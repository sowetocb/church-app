     <!-- Navbar -->

     <nav
     class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
     id="layout-navbar">
     <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
       <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
         <i class="bx bx-menu bx-md"></i>
       </a>
     </div>

     <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search Form -->
    <form action="{{ route('event.index') }}" method="GET" class="mb-4">
      <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
              <i class="bx bx-search bx-md"></i>
              <input
  type="text"
  name="q"
  class="form-control border-0 shadow-none ps-1 ps-sm-2"
  placeholder="Search events..."
  aria-label="Search..."
  autocomplete="off" />

          </div>
      </div>
  </form>
       <!-- /Search -->

       <script>
        window.addEventListener('load', function() {
            const url = new URL(window.location.href);
            if (url.searchParams.has('q')) {
                // Clear the q parameter from the URL without reloading the page
                url.searchParams.set('q', '');
                window.history.replaceState({}, document.title, url.pathname);
                
                // Optionally, if you want to clear the input field as well:
                document.querySelector('input[name="q"]').value = '';
            }
        });
    </script>
    

       <ul class="navbar-nav flex-row align-items-center ms-auto">
         <!-- Place this tag where you want the button to render. -->
         <li class="nav-item lh-1 me-4">
           <a
             class="github-button"
             href="https://github.com/themeselection/sneat-html-admin-template-free"
             data-icon="octicon-star"
             data-size="large"
             data-show-count="true"
             aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
             >Star</a
           >
         </li>

       <!-- User -->
<li class="nav-item navbar-dropdown dropdown-user dropdown">
  @if (Auth::check())
    <!-- If user is authenticated -->
    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
      <div class="avatar avatar-online">
        <img
          src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}"
          alt="Avatar"
          class="w-px-40 h-auto rounded-circle"
        />
      </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <li>
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          <div class="d-flex">
            <div class="flex-shrink-0 me-3">
              <div class="avatar avatar-online">
                <img
                  src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}"
                  alt="Avatar"
                  class="w-px-40 h-auto rounded-circle"
                />
              </div>
            </div>
            <div class="flex-grow-1">
              <h6 class="mb-0">{{ Auth::user()->name }}</h6>
              <small class="text-muted">{{ Auth::user()->role }}</small>
            </div>
          </div>
        </a>
      </li>
      <li>
        <div class="dropdown-divider my-1"></div>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
        </a>
      </li>
      <!-- Add more dropdown items if needed -->

      <li>
        <div class="dropdown-divider my-1"></div>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  @else
    <!-- If user is not authenticated (session expired or logged out) -->
    <a class="nav-link p-0" href="{{ route('login') }}">
      <div class="avatar avatar-offline">
        <img
          src="{{ asset('assets/img/avatars/1.png') }}"
          alt="Default Avatar"
          class="w-px-40 h-auto rounded-circle"
        />
      </div>
    </a>
  @endif
</li>
<!--/ User -->


       </ul>
     </div>
   </nav>

   <!-- / Navbar -->