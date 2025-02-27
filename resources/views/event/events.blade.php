@extends('layouts.adminpg')
@section('content')
<!-- Favicon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <!-- Header with Upcoming Events Title and Add Event Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
        <h2>Upcoming Events</h2>
        <a href="{{ route('event.create') }}" class="btn btn-primary">Add Event</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($events as $event)
            <div class="col">
                <div class="card h-100">
                    <div class="card-img-top text-center">
                        {!! $event->formatted_embed_code !!} <!-- Display YouTube video -->
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">{{ $event->description }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0"><strong>Date:</strong> {{ $event->event_date }}</p>
                            <!-- Delete Form (Hidden) -->
<form id="delete-form-{{ $event->id }}" action="{{ route('event.destroy', $event->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Clickable Trash Icon -->
<i class="fa-regular fa-trash-can" style="color: #ca1c1c; cursor: pointer;" onclick="confirmDelete('{{ $event->id }}')"></i>

<!-- JavaScript for Confirmation -->
<script>
    function confirmDelete(eventId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to undo this action!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + eventId).submit();
            }
        });
    }
</script>

                            
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


    <!-- Pagination (if needed) -->
    <div class="col-lg-8 mt-4">
        <div class="demo-inline-spacing">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($events->onFirstPage())
                        <li class="page-item prev disabled">
                            <span class="page-link">
                                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item prev">
                            <a class="page-link" href="{{ $events->previousPageUrl() }}">
                                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                            </a>
                        </li>
                    @endif

                    <!-- Page Number Links -->
                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $events->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($events->hasMorePages())
                        <li class="page-item next">
                            <a class="page-link" href="{{ $events->nextPageUrl() }}">
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
</div>



@endsection