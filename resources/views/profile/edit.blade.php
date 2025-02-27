@extends('layouts.adminpg')

@section('content')
<div class="container my-4">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between pb-3">
      <h5 class="mb-0">Profile Information</h5>
      <small class="text-muted float-end">Update your account’s profile information and email address.</small>
    </div>
    <div class="card-body pt-4">
      <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        
        <!-- Name Input -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-fullname2" class="input-group-text">
                <i class="bx bx-user"></i>
              </span>
              <input
                type="text"
                name="name"
                id="basic-icon-default-fullname"
                class="form-control"
                placeholder="John Doe"
                aria-label="John Doe"
                aria-describedby="basic-icon-default-fullname2"
                value="{{ old('name', Auth::user()->name) }}"
                required autofocus
              />
            </div>
            @if ($errors->has('name'))
              <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
            @endif
          </div>
        </div>
        
        <!-- Email Input -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span class="input-group-text">
                <i class="bx bx-envelope"></i>
              </span>
              <input
                type="email"
                name="email"
                id="basic-icon-default-email"
                class="form-control"
                placeholder="john.doe"
                aria-label="john.doe"
                aria-describedby="basic-icon-default-email2"
                value="{{ old('email', Auth::user()->email) }}"
                required
              />
              <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
            </div>
            @if ($errors->has('email'))
              <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
            @endif
            <div class="form-text">You can use letters, numbers & periods</div>
          </div>
        </div>
        
        <!-- Profile Image Upload -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="profile_image">Profile Image</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input
                type="file"
                name="profile_image"
                id="profile_image"
                class="form-control"
              />
            </div>
            @if ($errors->has('profile_image'))
              <div class="text-danger mt-2">{{ $errors->first('profile_image') }}</div>
            @endif
          </div>
        </div>
        
        <!-- Save Button -->
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between pb-3">
      <h5 class="mb-0">Update Password</h5>
      <small class="text-muted float-end">Ensure your account uses a long, random password to stay secure.</small>
    </div>
    <div class="card-body pt-4">
      <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <!-- Current Password -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="current_password">Current Password</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span class="input-group-text">
                <i class="bx bx-lock"></i>
              </span>
              <input 
                type="password"
                id="current_password"
                name="current_password"
                class="form-control"
                placeholder="Current Password"
                autocomplete="current-password"
              />
            </div>
            @if($errors->updatePassword->has('current_password'))
              <div class="text-danger mt-2">
                {{ $errors->updatePassword->first('current_password') }}
              </div>
            @endif
          </div>
        </div>
        <!-- New Password -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="password">New Password</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span class="input-group-text">
                <i class="bx bx-lock-open"></i>
              </span>
              <input 
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="New Password"
                autocomplete="new-password"
              />
            </div>
            @if($errors->updatePassword->has('password'))
              <div class="text-danger mt-2">
                {{ $errors->updatePassword->first('password') }}
              </div>
            @endif
          </div>
        </div>
        <!-- Confirm New Password -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="password_confirmation">Confirm Password</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span class="input-group-text">
                <i class="bx bx-lock-open"></i>
              </span>
              <input 
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Confirm New Password"
                autocomplete="new-password"
              />
            </div>
            @if($errors->updatePassword->has('password_confirmation'))
              <div class="text-danger mt-2">
                {{ $errors->updatePassword->first('password_confirmation') }}
              </div>
            @endif
          </div>
        </div>
        <!-- Save Button -->
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container my-4">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between pb-3">
      <h5 class="mb-0">Delete Account</h5>
      <small class="text-muted">
        Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data you wish to retain.
      </small>
    </div>
    <div class="card-body pt-4">
      <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')
  
        <!-- Password Input with Icon -->
        <div class="row mb-6">
          <label class="col-sm-2 col-form-label" for="delete_password">Password</label>
          <div class="col-sm-10">
            <div class="input-group input-group-merge">
              <span class="input-group-text">
                <i class="bx bx-lock"></i>
              </span>
              <input 
                type="password" 
                id="delete_password" 
                name="password" 
                class="form-control" 
                placeholder="Password" 
                autocomplete="current-password" 
                required
              />
            </div>
            @if($errors->userDeletion->has('password'))
              <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
            @endif
          </div>
        </div>
  
        <!-- Buttons: Cancel and Delete Account -->
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">
              Cancel
            </button>
            <button type="submit" class="btn btn-danger ms-2">
              Delete Account
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
