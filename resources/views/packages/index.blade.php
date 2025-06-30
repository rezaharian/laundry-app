@extends('layouts.apptr')

@section('content')
<div class="container">
    <h2>Daftar Paket Laundry</h2>
    <a href="{{ route('packages.create') }}" class="btn btn-primary mb-3">+ Tambah Paket</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Paket</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
            <tr>
                <td>{{ $package->nama }}</td>
                <td>{{ $package->deskripsi }}</td>
                <td>
                    <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
