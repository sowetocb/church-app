@extends('layouts.adminpg')

@section('content')

<div class="container">
  <!-- Basic Layout Card for Creating an Event -->
  <div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Create Event</h5>
        @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
        <small class="text-muted float-end">Fill in event details</small>
      </div>
      <div class="card-body">
        <form action="{{ route('event.store') }}" method="POST">
          @csrf
          <!-- Title Field -->
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="title">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="title" placeholder="Event Title" required />
            </div>
          </div>
          <!-- Description Field -->
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="description">Description</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="description" name="description" placeholder="Event description"></textarea>
            </div>
          </div>
          <!-- YouTube Embed Code Field -->
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="youtube_embed_code">YouTube Embed Code</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="youtube_embed_code" name="youtube_embed_code" placeholder="Paste the YouTube embed code" required></textarea>
            </div>
          </div>
          <!-- Event Date Field -->
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="event_date">Event Date</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="event_date" name="event_date" required />
            </div>
          </div>
          <!-- Submit Button -->
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Create Event</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
