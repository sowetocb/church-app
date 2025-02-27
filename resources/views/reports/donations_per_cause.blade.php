
@extends('layouts.adminpg')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h2>Donations Per Cause</h2>

  <!-- We'll adapt your "Customer Table" snippet -->
  <div class="col-xxl-7 mb-0">
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="invoice-list-table table table-border-top-0">
          <thead>
            <tr>
               
              <th>Cause</th>
              <th>Total Donations</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach($donations as $row)
              <tr>
                <!-- The cause relationship might be loaded, so we can do optional($row->cause)->title -->
                <td>
                  
                    <div class="d-flex flex-column">
                       
                      <!-- Show the cause title -->
                      <strong>{{ optional($row->cause)->title ?? 'N/A' }}</strong>
                    </div>
                  </div>

                </td>
                <td>
                  {{ $row->total_donations }}
                </td>
                <td>
                  Tsh{{ number_format($row->total_amount, 2) }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
       
      </div>
    
    </div>
    @if(isset($grandTotal))
    <div class="mt-4">
      <strong>Grand Total :</strong> Tshs{{ number_format($grandTotal, 2) }}
    </div>
  @endif
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

  <!-- Optional: Show your "grand total" on the current page of results -->
 
</div>
@endsection
