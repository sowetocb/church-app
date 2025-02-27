@extends('layouts.adminpg')



@section('content')
<div class="container">
  <h2 class="mb-4">Donations Table for Cause: {{ $cause->title }}</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <h5 class="card-header">Donations</h5>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Donor Name</th>
              <th>Email / Phone</th>
              <th>cause name</th>
              <th>Amount</th>
              <th>Payment Status</th>
              <th>Donation Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($donations as $donation)
            <tr>
              <td>{{ $donation->id }}</td>
              <td>{{ $donation->donor_name }}</td>
              <td>{{ $donation->donor_email ?? $donation->mobile_number }}</td>
              <td>{{ $cause->title }}</td>
              <td>${{ number_format($donation->amount, 2) }}</td>
              <td>
                <span class="badge bg-{{ $donation->payment_status == 'paid' ? 'success' : 'warning' }}">
                  {{ ucfirst($donation->payment_status) }}
                </span>
              </td>
              <td>{{ $donation->created_at->format('M d, Y') }}</td>
              <td>
                <!-- actions (edit/delete) as needed -->
                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      {{ $donations->links() }}
    </div>
  </div>
</div>
@endsection

