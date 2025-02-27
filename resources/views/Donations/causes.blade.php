
{{-- ====================== CAUSES SECTION ====================== --}}
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
                  @if(auth()->check() && auth()->user()->role === 'admin')
                  <!-- Admin-only buttons -->
                  <form action="{{ route('causes.destroy', $cause->id) }}" method="POST" class="d-inline-block ms-2">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this cause?');">
                          Delete Cause
                      </button>
                  </form>
                @endif
                
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
            </div> <!-- d-flex align-items-start row -->
          </div> <!-- card -->
        </div> <!-- col-xxl-8 -->
      </div> <!-- row -->
    @endforeach

    <!-- Pagination for $causes -->
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

    <script>
        let currentPage = {{ $causes->currentPage() }};
        let lastPage    = {{ $causes->lastPage() }};
        
        function updateCauses() {
          let nextPage = currentPage < lastPage ? currentPage + 1 : 1;
          let url = `{{ route('causes.partial') }}?page=${nextPage}`;
      
          fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          })
          .then(response => response.text())
          .then(html => {
            // Update only the cause card container.
            document.getElementById('causesContainer').innerHTML = html;
            currentPage = nextPage;
          })
          .catch(error => console.error('Error loading causes:', error));
        }
      
        // Auto-advance every 10 seconds.
        setInterval(updateCauses, 10000);
      </script>
      

  @else
    <p>No causes found. 
      <a href="{{ route('causes.create') }}">Create one</a>
    </p>
  @endif
</div> <!-- end container-xxl for causes -->
