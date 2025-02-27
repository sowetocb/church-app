@extends('layouts.adminpg')

@section('content')
<div class="container">
  <h2 class="text-center mb-4">Pledge / Donate for the New Church</h2>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  <div class="col-xxl">
    <div class="card mb-6">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">My Own Donation Form</h5>
        <small class="text-muted float-end">Please fill your details</small>
      </div>
      <div class="card-body">
        <form action="{{ route('donations.myOwnDonateStore') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="donor_name">Name</label>
            <div class="col-sm-10">
              <input 
                type="text" 
                name="donor_name" 
                id="donor_name" 
                class="form-control"
                placeholder="John Doe"
                required
              >
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="amount">Amount</label>
            <div class="col-sm-10">
              <input
                type="number"
                name="amount"
                id="amount"
                class="form-control"
                placeholder="50.00"
                min="1"
                step="0.01"
                required
              >
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="message">Message</label>
            <div class="col-sm-10">
              <textarea
                name="message"
                id="message"
                class="form-control"
                placeholder="A note or prayer for the new church..."
              ></textarea>
            </div>
          </div>
          <div class="row mb-6">
            <label class="col-sm-2 col-form-label" for="donation_image">Upload Image</label>
            <div class="col-sm-10">
              <input type="file" name="donation_image" id="donation_image" class="form-control">
            </div>
          </div>
          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Donate Now</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
