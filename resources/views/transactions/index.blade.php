@extends('layouts.apptr')

@section('content')
    <div class="container py-3">
        <h5 class="mb-3 fw-semibold">Daftar Transaksi</h5>

        @if (session('success'))
            <div class="alert alert-success small py-2 px-3 mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small text-muted">Total: {{ $transactions->count() }} transaksi</span>
            <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary px-3 py-1">
                + Transaksi
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered align-middle small mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%">#</th>
                        <th>Customer</th>
                        <th>Petugas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $trx->pelanggan_nama }}</td>
                            <td>{{ $trx->user->name }}</td>
                            <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if ($trx->tanggal_keluar)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('transactions.show', $trx->id) }}"
                                    class="btn btn-sm btn-outline-info px-2 py-1 me-1">Detail</a>
                                <a href="{{ route('transactions.edit', $trx->id) }}"
                                    class="btn btn-sm btn-outline-warning px-2 py-1 me-1">Edit</a>
                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger px-2 py-1"
                                        onclick="return confirm('Yakin hapus transaksi?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
