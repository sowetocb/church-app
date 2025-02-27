<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($events as $event)
        <div class="col">
            <div class="card h-100">
                <div class="card-img-top text-center">
                    {!! $event->formatted_embed_code !!}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-text">{{ $event->description }}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0"><strong>Date:</strong> {{ $event->event_date }}</p>
                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
