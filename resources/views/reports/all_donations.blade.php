@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h2>All Donations Report</h2>
  <a href="{{ route('reports.allDonations.pdf') }}" class="btn btn-primary">Download PDF</a>

  <div class="col-xxl-7 mb-0">
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="invoice-list-table table table-border-top-0">
          <thead>
            <tr>
              <th>Customer</th>
              <th>Amount</th>
              <th>Status</th>
              
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($donations as $donation)
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                  
                    <div class="d-flex flex-column">
                      <!-- Donation's donor name and email -->
                      <strong>{{ $donation->donor_name }}</strong>
                      <small class="text-body">{{ $donation->donor_email ?? 'No email' }}</small>
                    </div>
                  </div>
                </td>
                <td>
                  {{ number_format($donation->amount, 2) }}
                </td>
                <td>
                  @if($donation->payment_status === 'paid')
                    <span class="badge bg-label-success">Paid</span>
                  @elseif($donation->payment_status === 'pending')
                    <span class="badge bg-label-warning">Pending</span>
                  @else
                    <span class="badge bg-label-danger">Failed</span>
                  @endif
                </td>
               
                
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

  <!-- Optionally, show total amount -->
  <div class="mt-3">
    <strong>Total Amount: </strong> ${{ number_format($totalAmount, 2) }}
  </div>

</div>
@endsection
