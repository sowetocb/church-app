  <!-- Menu -->

  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="" class="app-brand-link d-flex align-items-center">
        <span class="app-brand-logo demo">
          <img src="{{ asset('storage/images/logo1.png') }}" alt="tru" style="width: 40px; height: auto;">
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 16px; white-space: nowrap;">trustee</span>
      </a>
      
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i href="{{url('admin/dashboard')}}" class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
      </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item active open">
        <a href="{{url('admin/dashboard')}}" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-home-smile"></i>
          <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
         
        </a>
        
        <ul class="menu-sub">
         
            <li class="menu-item active">
              <a href="{{url('admin/dashboard')}}" class="menu-link">
                <div class="text-truncate" data-i18n="Analytics">home
                </div>
              </a>
            </li>

          <li class="menu-item active">
            <a href="{{ url('event')}}" class="menu-link">
              <div class="text-truncate" data-i18n="Analytics">events</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="{{url('causes-donations')}}"
              target="_blank"
              class="menu-link">
              <div class="text-truncate" data-i18n="CRM">Donation</div>
            </a>
          </li>
          <li class="menu-item">
            <a
              href="{{ route('admin.users.index') }}"
              target="_blank"
              class="menu-link">
              <div class="text-truncate" data-i18n="Logistics">User MGT</div>  
            </a>
          </li>
          <!-- ... existing menu code ... -->
<!-- Add this new Reports menu item -->
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-chart"></i>
    <div class="text-truncate" data-i18n="Reports">Reports</div>
  </a>
  <ul class="menu-sub">
    <li class="menu-item">
      <a href="{{ route('reports.allDonations') }}" class="menu-link">
        <div class="text-truncate" data-i18n="All Donations">All Donations</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('reports.donationsPerCause') }}" class="menu-link">
        <div class="text-truncate" data-i18n="Donations Per Cause">Donations Cause</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('reports.paidPending') }}" class="menu-link">
        <div class="text-truncate" data-i18n="Paid vs. Pending">Paid & Pending</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('reports.paidPendingByCause') }}" class="menu-link">
        <div class="text-truncate" data-i18n="Paid vs. Pending By Cause">Paid & Pending Cause</div>
      </a>
    </li>
   
  </ul>
</li>
</aside>
  <!-- / Menu -->