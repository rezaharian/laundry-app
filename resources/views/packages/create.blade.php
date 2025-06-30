@extends('layouts.apptr')

@section('content')
    <div class="container">
        <h2>Tambah Paket</h2>
        <form action="{{ route('packages.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Paket</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
