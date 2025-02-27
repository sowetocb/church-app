@extends('layouts.adminpg')

@section('content')



<div class="container">
  <h1 class="mb-4">All Donations for All Causes</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <h5 class="card-header">All Donations</h5>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cause name</th> <!-- or Cause Title if you want -->
              <th>Donor Name</th>
              <th>Email / Mobile</th>
              <th>Amount</th>
              <th>Payment Status</th>
              <th>Donation Date</th>
             
            </tr>
          </thead>
          <tbody>
            @foreach($donations as $donation)
            <tr>
              <td>{{ $donation->id }}</td>

              <!-- If your donations table references cause with event_id -->
             
              <td>{{ $donation->cause?->title ?? 'N/A' }}</td>


              <td>{{ $donation->donor_name }}</td>
              <td>{{ $donation->donor_email ?? $donation->mobile_number }}</td>
              <td>${{ number_format($donation->amount, 2) }}</td>
              <td>
                <span class="badge bg-{{ $donation->payment_status == 'paid' ? 'success' : 'warning' }}">
                  {{ ucfirst($donation->payment_status) }}
                </span>
              </td>
              <td>{{ $donation->created_at->format('M d, Y') }}</td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
    
    </div>
  </div>
</div>
@endsection
