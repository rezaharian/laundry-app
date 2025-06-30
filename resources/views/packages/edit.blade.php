@extends('layouts.apptr')

@section('content')
    <div class="container">
        <h2>Edit Paket</h2>
        <form action="{{ route('packages.update', $package->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama Paket</label>
                <input type="text" name="nama" class="form-control" value="{{ $package->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $package->deskripsi }}</textarea>
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
