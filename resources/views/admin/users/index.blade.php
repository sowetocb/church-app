@extends('layouts.adminpg')

@section('content')
<div class="container">
  <h2 class="mb-4">User Management</h2>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->phone }}</td>
          <td>
            <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
              @csrf
              @method('PATCH')
              <select name="role" class="form-select" onchange="this.form.submit()">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
              </select>
            </form>
          </td>
          <td>
            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Custom Pagination using $users variable -->
  <div class="col-lg-8 mt-4">
    <div class="demo-inline-spacing">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <!-- Previous Page Link -->
          @if ($users->onFirstPage())
            <li class="page-item prev disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </span>
            </li>
          @else
            <li class="page-item prev">
              <a class="page-link" href="{{ $users->previousPageUrl() }}">
                <i class="icon-base bx bx-chevrons-left icon-sm"></i>
              </a>
            </li>
          @endif

          <!-- Page Number Links -->
          @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach

          <!-- Next Page Link -->
          @if ($users->hasMorePages())
            <li class="page-item next">
              <a class="page-link" href="{{ $users->nextPageUrl() }}">
                <i class="icon-base bx bx-chevrons-right icon-sm"></i>
              </a>
            </li>
          @else
            <li class="page-item next disabled">
              <span class="page-link">
                <i class="icon-base bx bx-chevrons-right icon-sm"></i>
              </span>
            </li>
          @endif
        </ul>
      </nav>
    </div>
  </div>
</div>
@endsection

