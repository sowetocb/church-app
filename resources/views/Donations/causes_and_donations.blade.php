@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div id="causesContainer">
    @include('donations.causes')
  </div>
  

<div class="container">
  <div class="row align-items-stretch">
    <!-- Small Card 1 -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title text-primary mb-3"><span class="avatar-initial rounded bg-label-success"><i class="icon-base bx bx-dollar"></i></span>  fund support</h5>
          <p> Voda: 0748 602 680 </p>
          <p>FAMILY OF PRAYING WOMAN </p>
        </div>
      </div>
    </div>
    <!-- Small Card 2 -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title text-primary mb-3"><span class="avatar-initial rounded bg-label-success"><i class="bx bx-chat"></i></i></span>Personal contact</h5>
          <p> 0787 460 581 </p>
          <p>contact with pastor personally </p>
        </div>
      </div>
    </div>
    <!-- Big Card -->
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title text-primary mb-3"><span class="avatar-initial rounded bg-label-success"><i class="bx bx-conversation"></i></span>Pastoral counseling(office number)</h5>
          <p>0674 222 222</p>
          <p>contact with pastor in office number</p>
        </div>
      </div>
    </div>
  </div>
</div>
@if(auth()->check() && auth()->user()->role === 'admin')
{{-- ====================== DONATIONS SECTION ====================== --}}
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">All Donations</h2>
    <!-- Button on the right side to Add a New Cause -->
    <a href="{{ route('causes.create') }}" class="btn btn-primary">Add Cause</a>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cause Name</th>
              <th>Donor Name</th>
              <th>Amount</th>
              <th>Payment Status</th>
              <th>Donation Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($donations as $donation)
            <tr>
              <td>{{ $donation->id }}</td>
              <td>{{ optional($donation->cause)->title ?? 'N/A' }}</td>
              <td>{{ $donation->donor_name }}</td>
             
              <td>${{ number_format($donation->amount, 2) }}</td>
              <td>
                <span class="badge bg-{{ $donation->payment_status == 'paid' ? 'success' : 'warning' }}">
                  {{ ucfirst($donation->payment_status) }}
                </span>
              </td>
              <td>{{ $donation->created_at->format('M d, Y') }}</td>
              <td>
                @if($donation->payment_status === 'pending')
                  <!-- Approve (Mark as Paid) button -->
                  <form action="{{ route('donations.approve', $donation->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-outline-success">Approve</button>
                  </form>
                @endif
            
                <!-- Edit link -->
                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
            
                <!-- Delete link -->
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>

      <!-- Custom Pagination for $donations -->
      <div class="col-lg-8 mt-4">
        <div class="demo-inline-spacing">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <!-- Previous Page Link -->
              @if ($donations->onFirstPage())
                <li class="page-item prev disabled">
                  <span class="page-link">
                    <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                  </span>
                </li>
              @else
                <li class="page-item prev">
                  <a class="page-link" href="{{ $donations->previousPageUrl() }}">
                    <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                  </a>
                </li>
              @endif

              <!-- Page Number Links -->
              @foreach ($donations->getUrlRange(1, $donations->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $donations->currentPage() ? 'active' : '' }}">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endforeach

              <!-- Next Page Link -->
              @if ($donations->hasMorePages())
                <li class="page-item next">
                  <a class="page-link" href="{{ $donations->nextPageUrl() }}">
                    <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                  </a>
                </li>
              @else
                <li class="page-item next disabled">
                  <span class="page-link">
                    <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                  </span>
                </li>
              @endif
            </ul>
          </nav>
        </div>
        @else
        <div class="container">
          <h2 class="mb-4">My Donations</h2>
        
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
        
          <div class="card">
            <h5 class="card-header">My Donations</h5>
            <div class="card-body">
              <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Cause name</th>
                      <th>Donor Name</th>
                      <th>Email / Mobile</th>
                      <th>Amount</th>
                      <th>Payment Status</th>
                      <th>Donation Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($donations as $donation)
                    <tr>
                      <td>{{ $donation->id }}</td>
                      <td>{{ $donation->cause?->title ?? 'N/A' }}</td>
                      <td>{{ $donation->donor_name }}</td>
                      <td>{{ $donation->donor_email ?? $donation->mobile_number }}</td>
                      <td>${{ number_format($donation->amount, 2) }}</td>
                      <td>
                        <span class="badge bg-{{ $donation->payment_status == 'paid' ? 'success' : 'warning' }}">
                          {{ ucfirst($donation->payment_status) }}
                        </span>
                      </td>
                      <td>{{ $donation->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
        
              <!-- Custom Pagination -->
              <!-- Custom Pagination -->
          <div class="col-lg-8 mt-4">
            <div class="demo-inline-spacing">
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <!-- Previous Page Link -->
                  @if ($donations->onFirstPage())
                    <li class="page-item prev disabled">
                      <span class="page-link">
                        <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                      </span>
                    </li>
                  @else
                    <li class="page-item prev">
                      <a class="page-link" href="{{ $donations->previousPageUrl() }}">
                        <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                      </a>
                    </li>
                  @endif
        
                  <!-- Page Number Links -->
                  @foreach ($donations->getUrlRange(1, $donations->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $donations->currentPage() ? 'active' : '' }}">
                      <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                  @endforeach
        
                  <!-- Next Page Link -->
                  @if ($donations->hasMorePages())
                    <li class="page-item next">
                      <a class="page-link" href="{{ $donations->nextPageUrl() }}">
                        <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                      </a>
                    </li>
                  @else
                    <li class="page-item next disabled">
                      <span class="page-link">
                        <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                      </span>
                    </li>
                  @endif
                </ul>
              </nav>
            </div>
          </div>
          <!-- End Custom Pagination -->

      </div>
      <!-- End Custom Pagination for $donations -->
    </div>
  </div>
  @endif
</div>

@endsection
