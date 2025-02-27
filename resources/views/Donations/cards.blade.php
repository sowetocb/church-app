@extends('layouts.adminpg')

@section('content')


<div class="container">
  <h2 class="text-center mb-4">Donations for Event: {{ $cause->title }}</h2>
  
  <div class="row mb-12 g-6">
    @foreach($donations as $donation)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img class="card-img-top" src="{{ $donation->donation_image ? asset('storage/' . $donation->donation_image) : '../assets/img/elements/2.jpg' }}" alt="Donation Image" />
          <div class="card-body">
            <h5 class="card-title">{{ $donation->donor_name }}</h5>
           
            <a href="javascript:void(0)" class="btn btn-outline-primary">View Details</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Pagination Links -->
  {{ $donations->links() }}
</div>

@endsection
