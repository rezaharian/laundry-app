@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Layanan Tambahan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('services.create') }}" class="btn btn-primary mb-3">+ Tambah Layanan</a>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $service->nama }}</td>
                        <td>{{ $service->deskripsi }}</td>
                        <td>Rp {{ number_format($service->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus?')"
                                    class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada layanan tambahan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
