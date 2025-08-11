@extends('layouts.app')
@section('title', 'CSR PLN Nusantara Power UP Paiton')
@section('content')
    <div class="container">
        <h3>Edit Nama Bisnis Support</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('business-support.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Bisnis Support</label>
                <input type="text" id="nama" name="nama" class="form-control"
                    value="{{ old('nama', $support->nama ?? '') }}" required>
                @error('nama')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button
                style="background-color: #78C841; color: white; border: none; padding: 0.375rem 0.75rem; border-radius: 0.25rem; cursor: pointer;">
                Simpan
            </button>

        </form>
    </div>
@endsection
