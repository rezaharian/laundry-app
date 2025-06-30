@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Tambah Layanan Tambahan</h2>

        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
