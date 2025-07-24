@extends('layouts.app')
@section('title', 'Profil & Ganti Password')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">Profil & Ganti Password</h5>
    
    <div class="row">
      <!-- KIRI: Avatar + Detail User -->
     <div class="col-md-6 d-flex justify-content-center align-items-center">
  <div class="text-center">
    <!-- Avatar -->
    <div class="mb-3">
      <img src="{{ asset('images/profile/user-1.jpg') }}"
           alt="User Avatar"
           class="rounded-circle"
           style="width: 120px; height: 120px; object-fit: cover;">
    </div>

    <!-- Detail User -->
    <div class="text-center">
      <p><strong>{{ Auth::user()->nama }}</strong></p>
      <p><strong>{{ Auth::user()->role }}</strong></p>
      <p><strong>{{ Auth::user()->username ?? '-' }}</strong></p>
    </div>
  </div>
</div>


      <!-- KANAN: Form Ganti Password -->
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="card-title fw-semibold mb-3">Ganti Password</h6>
           <form method="POST" action="{{ route('password.update') }}">
  @csrf
  @method('PUT')

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="mb-3">
    <label for="new_password" class="form-label">Password Baru</label>
    <input type="password" class="form-control" id="new_password" name="password" required>
  </div>
  <div class="mb-3">
    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
  </div>
  <button type="submit" style="background-color: #78C841; color: white;" class="btn w-100">Submit</button>
</form>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
