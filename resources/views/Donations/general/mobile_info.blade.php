@extends('layouts.adminpg')

@section('content')
<div class="container">
  <div class="row align-items-stretch">
    <!-- Small Card 1 -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Small Card 1</h5>
          <p>Some short info or data.</p>
        </div>
      </div>
    </div>
    <!-- Small Card 2 -->
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Small Card 2</h5>
          <p>Some short info or data.</p>
        </div>
      </div>
    </div>
    <!-- Big Card -->
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Big Card</h5>
          <p>This card is a bit wider (6 columns) but shares the same height as the smaller ones.</p>
          <p>You can put more detailed information here.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

