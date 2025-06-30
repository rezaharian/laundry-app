@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Edit Layanan Tambahan</h2>

        <form action="{{ route('services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="nama" class="form-control" value="{{ $service->nama }}" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $service->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $service->harga }}" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
