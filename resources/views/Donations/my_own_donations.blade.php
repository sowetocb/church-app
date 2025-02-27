@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="container-xxl flex-grow-1 container-p-y">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
  
    @if($causes->count())
      @foreach($causes as $cause)
        <div class="row">
          <div class="col-xxl-8 mb-6 order-0">
            <div class="card">
              <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="card-title text-primary mb-3">{{ $cause->title }}</h5>
                    <p class="mb-6">
                      {{ $cause->description }}
                    </p>
                    <!-- Donate / Promise button -->
                    <a href="{{ route('donations.causes.create', ['cause' => $cause->id]) }}" class="btn btn-sm btn-outline-primary">
                      Donate / Promise
                    </a>
                    
                    <!-- Delete cause (admin only) -->
                    <form action="{{ route('causes.destroy', $cause->id) }}" method="POST" class="d-inline-block ms-2">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this cause?');">
                        Delete Cause
                      </button>
                    </form>
                  </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                  <div class="card-body pb-0 px-0 px-md-6">
                    @if($cause->image)
                      <img
                        src="{{ asset('storage/' . $cause->image) }}"
                        height="175"
                        alt="Cause Image"
                      />
                    @else
                      <img
                        src="../assets/img/illustrations/man-with-laptop.png"
                        height="175"
                        alt="Default Cause Image"
                      />
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
  
      <!-- Custom Pagination -->
      <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination pagination-secondary">
          <!-- First Page Link -->
          @if ($causes->currentPage() > 1)
            <li class="page-item first">
              <a class="page-link" href="{{ $causes->url(1) }}">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </a>
            </li>
          @else
            <li class="page-item first disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </span>
            </li>
          @endif
  
          <!-- Previous Page Link -->
          @if ($causes->onFirstPage())
            <li class="page-item prev disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevron-left icon-sm"></i>
              </span>
            </li>
          @else
            <li class="page-item prev">
              <a class="page-link" href="{{ $causes->previousPageUrl() }}">
                <i class="icon-base bx bx-chevron-left icon-sm"></i>
              </a>
            </li>
          @endif
  
          <!-- Page Number Links -->
          @foreach ($causes->getUrlRange(1, $causes->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $causes->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach
  
          <!-- Next Page Link -->
          @if ($causes->hasMorePages())
            <li class="page-item next">
              <a class="page-link" href="{{ $causes->nextPageUrl() }}">
                <i class="icon-base bx bx-chevron-right icon-sm"></i>
              </a>
            </li>
          @else
            <li class="page-item next disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevron-right icon-sm"></i>
              </span>
            </li>
          @endif
  
          <!-- Last Page Link -->
          @if ($causes->currentPage() < $causes->lastPage())
            <li class="page-item last">
              <a class="page-link" href="{{ $causes->url($causes->lastPage()) }}">
                <i class="icon-base bx bx-chevrons-right icon-sm"></i>
              </a>
            </li>
          @else
            <li class="page-item last disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevrons-right icon-sm"></i>
              </span>
            </li>
          @endif
        </ul>
      </nav>
      <!-- End Custom Pagination -->
  
      <!-- Always run the script -->
      <script>
        console.log("Auto-advance script loaded.");
  
        setTimeout(function() {
          console.log("Auto-advance timer fired.");
  
          var currentPage = {{ $causes->currentPage() }};
          var lastPage = {{ $causes->lastPage() }};
          var nextUrl = "{{ $causes->nextPageUrl() }}";
          var firstUrl = "{{ $causes->url(1) }}";
  
          if (currentPage < lastPage) {
            console.log("Going to next page: " + nextUrl);
            window.location.href = nextUrl;
          } else {
            console.log("Cycling back to first page: " + firstUrl);
            window.location.href = firstUrl;
          }
        }, 10000);
      </script>
  
    @else
      <p>No causes found. <a href="{{ route('causes.create') }}">Create one</a></p>
    @endif
  </div>

 

  <!-- OPTIONAL: Display recent donations if you want -->
  <h2 class="text-center mb-4 mt-4">Recent Donations</h2>
 
  <div class="container">
    <h5 class="mb-4">Donations Table for My Own Cause</h5>
    <div class="card">
      <h5 class="card-header">Donations</h5>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
  
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <!-- Include an ID column -->
                <th>ID</th>
                <th>Donor Name</th>
                <th>Email / Mobile</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Donation Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($donations as $donation)
              <tr>
                <td>{{ $donation->id }}</td> <!-- The ID column -->
                <td>{{ $donation->donor_name }}</td>
                <td>{{ $donation->donor_email ?? $donation->mobile_number }}</td>
                <td>${{ number_format($donation->amount, 2) }}</td>
                <td>
                  <span class="badge bg-{{ $donation->payment_status == 'paid' ? 'success' : 'warning' }}">
                    {{ ucfirst($donation->payment_status) }}
                  </span>
                </td>
                <td>{{ $donation->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="dropdown">
                    <button
                      type="button"
                      class="btn p-0 dropdown-toggle hide-arrow"
                      data-bs-toggle="dropdown">
                      <i class="icon-base bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                      </a>
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base bx bx-trash me-1"></i> Delete
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
  </div>

  
@endsection
