@extends('layouts.adminpg')

@section('content')
<div class="container my-4">
  <h2 class="text-center mb-4">Create a New Cause</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card mb-6">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">New Cause Form</h5>
      <small class="text-muted float-end">Please fill out the details</small>
    </div>
    <div class="card-body">
      <form action="{{ route('causes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="title">Cause Title</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="title"
              id="title"
              class="form-control"
              placeholder="New Church Building"
              required
            >
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="description">Description</label>
          <div class="col-sm-10">
            <textarea
              name="description"
              id="description"
              class="form-control"
              placeholder="Describe the cause..."
            ></textarea>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="image">Cause Image</label>
          <div class="col-sm-10">
            <input
              type="file"
              name="image"
              id="image"
              class="form-control"
            >
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Create Cause</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
