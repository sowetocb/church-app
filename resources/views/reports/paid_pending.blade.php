@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h2 class="mb-4">Paid and Pending for All Causes</h2>

  <div class="row align-items-stretch">
    <!-- Card 1: Paid Donations (Small) -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body text-center">
          <h4 class="card-title text-primary mb-3">
            <span class="avatar-initial rounded bg-label-success">
              <i class="icon-base bx bx-dollar"></i>
            </span>Paid Donations
          </h4>
          <p class="mb-1">Donors: {{ $paidCount }}</p>
          <p class="mb-0">Total Amount    Tsh #{{ number_format($paidTotal, 2) }}</p>
        </div>
      </div>
    </div>

    <!-- Card 2: Pending Donations (Small) -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body text-center">
          <h4 class="card-title text-primary mb-3">
            <span class="avatar-initial rounded bg-label-success">
              <i class="icon-base bx bx-dollar"></i>
            </span>Pending Donations
          </h4>
          <p class="mb-1">Donors: {{ $pendingCount }}</p>
          <p class="mb-0">Total Amount     Tsh #{{ number_format($pendingTotal, 2) }}</p>
        </div>
      </div>
    </div> 

    <!-- Card 3: Overall Donations (Large) -->
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body text-center">
          <h4 class="card-title text-primary mb-3">
            <span class="avatar-initial rounded bg-label-success">
              <i class="icon-base bx bx-dollar"></i>
            </span>Overall Total Donations
          </h4>
          <p class="mb-1">Donors: {{ $overallCount }}</p>
          <p class="mb-0">Total Amount  Tsh #{{ number_format($overallTotal, 2) }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Add extra space between summary cards and the donation table -->
  <div class="mt-5"></div>

  <!-- Customer Table snippet with the donation rows -->
  <div class="col-xxl-7 mb-0">
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="invoice-list-table table table-border-top-0">
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
              <td>{{ $donation->cause ? $donation->cause->title : 'N/A' }}</td>
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
    </div>
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
@endsection
