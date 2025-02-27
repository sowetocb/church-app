@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h2>Paid & Pending by each Cause </h2>

  <!-- We'll adapt your "Customer Table" snippet to show cause, status, donation_count, amount_sum -->

  <div class="col-xxl-7 mb-0">
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="invoice-list-table table table-border-top-0">
          <thead>
            <tr>
              <th>Cause</th>
              <th>Status</th>
              <th>Donation Count</th>
              <th>Amount Sum</th>
              
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($stats as $record)
              <tr>
                <!-- "Customer" column replaced with "Cause" information -->
                <td>
                 
                    </div>
                    <div class="d-flex flex-column">
                      <!-- Show the cause title or 'N/A' -->
                      <strong>{{ optional($record->cause)->title ?? 'N/A' }}</strong>
                    </div>
                  </div>
                </td>

                <!-- "Amount" replaced with 'Status' -->
                <td>
                  @if($record->payment_status === 'paid')
                    <span class="badge bg-label-success">Paid</span>
                  @elseif($record->payment_status === 'pending')
                    <span class="badge bg-label-warning">Pending</span>
                  @else
                    <span class="badge bg-label-danger">{{ ucfirst($record->payment_status) }}</span>
                  @endif
                </td>

                <!-- "Status" replaced with 'Donation Count' -->
                <td>{{ $record->donation_count }}</td>

                <!-- "Paid By" replaced with 'Amount Sum' -->
                <td class="text-center">
                  Tsh{{ number_format($record->amount_sum, 2) }}
                </td>

                <!-- Actions -->
               
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Custom Pagination for $stats -->
  <div class="col-lg-8 mt-4">
    <div class="demo-inline-spacing">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <!-- Previous Page Link -->
          @if ($stats->onFirstPage())
            <li class="page-item prev disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </span>
            </li>
          @else
            <li class="page-item prev">
              <a class="page-link" href="{{ $stats->previousPageUrl() }}">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </a>
            </li>
          @endif

          <!-- Page Number Links -->
          @foreach ($stats->getUrlRange(1, $stats->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $stats->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach

          <!-- Next Page Link -->
          @if ($stats->hasMorePages())
            <li class="page-item next">
              <a class="page-link" href="{{ $stats->nextPageUrl() }}">
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
