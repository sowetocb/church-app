@extends('layouts.adminpg')

@section('content')

  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-xxl-8 mb-6 order-0">
        <div class="card">
          <div class="d-flex align-items-start row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary mb-3">Congratulations  {{Auth::user()->name}}🎉</h5>
                <p class="mb-6">
                  Thank you for join US <br />Click the button below to join our whatsapp group
                </p>
                
                <a href="https://chat.whatsapp.com/D8CF5IxkRd80eMxPPqYeyt" class="btn btn-sm btn-outline-primary">Join Us on whatsapp</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- / Content -->

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
</div><br>  

<div class="container">
  <h2 class="text-center">Upcoming Events</h2>
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
                      <p><strong>Date:</strong> {{ $event->event_date }}</p>
                  </div>
              </div>
          </div>
      @endforeach
  </div>

  <!-- Pagination Links -->
  <div class="col-lg-8">
    <div class="demo-inline-spacing">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Previous Page Link -->
                @if ($events->onFirstPage())
                    <li class="page-item prev disabled">
                        <span class="page-link"><i class="icon-base bx bx-chevrons-left icon-sm"></i></span>
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
                        <span class="page-link"><i class="icon-base bx bx-chevrons-right icon-sm"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

         @endsection
