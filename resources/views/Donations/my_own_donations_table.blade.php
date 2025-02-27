@extends('layouts.adminpg')

@section('content')
<div class="container">
  <h2 class="mb-4">Donations Table for My Own Cause</h2>
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
                <td>{{ $donation->id }}</td>
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
  </div>
</div>
@endsection
