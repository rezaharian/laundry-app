@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Tambah Item Layanan</h2>

        <form action="{{ route('package-items.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="package_id" class="form-label">Jenis Paket</label>
                <select name="package_id" class="form-control" required>
                    <option value="">-- Pilih Paket --</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}">{{ $package->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Item</label>
                <input type="text" name="nama_item" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="kg">kg</option>
                    <option value="pcs">pcs</option>
                    <option value="meter">meter</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tipe (khusus karpet/gordyn)</label>
                <select name="tipe" class="form-control">
                    <option value="">-- Tidak ada --</option>
                    <option value="tipis">Tipis</option>
                    <option value="tebal">Tebal</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('package-items.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
