@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Edit Item Layanan</h2>

        <form action="{{ route('package-items.update', $package_item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="package_id" class="form-label">Jenis Paket</label>
                <select name="package_id" class="form-control" required>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}"
                            {{ $package_item->package_id == $package->id ? 'selected' : '' }}>
                            {{ $package->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Item</label>
                <input type="text" name="nama_item" class="form-control" value="{{ $package_item->nama_item }}" required>
            </div>

            <div class="mb-3">
                <label>Satuan</label>
                <select name="satuan" class="form-control" required>
                    <option value="kg" {{ $package_item->satuan == 'kg' ? 'selected' : '' }}>kg</option>
                    <option value="pcs" {{ $package_item->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
                    <option value="meter" {{ $package_item->satuan == 'meter' ? 'selected' : '' }}>meter</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tipe</label>
                <select name="tipe" class="form-control">
                    <option value="">-- Tidak ada --</option>
                    <option value="tipis" {{ $package_item->tipe == 'tipis' ? 'selected' : '' }}>Tipis</option>
                    <option value="tebal" {{ $package_item->tipe == 'tebal' ? 'selected' : '' }}>Tebal</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $package_item->harga }}" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('package-items.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
