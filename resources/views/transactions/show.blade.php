@extends('layouts.apptr')

@section('content')
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-3 fw-semibold">Detail Transaksi</h5>
            </div> {{-- biarkan kosong sebagai penyeimbang kiri --}}
            <a href="{{ route('transactions.cetak', $transaction->id) }}" target="_blank" class="ms-auto">
                <button class="btn btn-sm btn-outline-primary">
                    🖨 Cetak
                </button>
            </a>
        </div>


        <div class="card shadow-sm border-0 mb-3 small">
            <div class="card-body px-3 py-2">
                <div class="row row-cols-md-4 g-2">
                    <div>
                        <strong>Customer:</strong>
                        {{ $transaction->pelanggan_nama }}
                    </div>
                    <div>
                        <strong>Petugas:</strong>
                        {{ $transaction->user->name }}
                    </div>
                    <div>
                        <strong>Tanggal Masuk:</strong>
                        {{ \Carbon\Carbon::parse($transaction->tanggal_masuk)->format('d M Y') }}
                    </div>
                    <div>
                        <strong>Status:</strong>
                        @if ($transaction->tanggal_keluar)
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-warning text-dark">Dalam Proses</span>
                        @endif
                        -
                        {{ $transaction->tanggal_keluar ? \Carbon\Carbon::parse($transaction->tanggal_keluar)->format('d M Y') : '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ITEM LAUNDRY --}}
        <h6 class="fw-semibold mb-2">Item Laundry</h6>
        <div class="table-responsive small">
            <table class="table table-sm table-bordered">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @forelse ($transaction->items as $item)
                        @php
                            $harga = $item->packageItem->harga ?? 0;
                            $subtotal = $item->jumlah * $harga;
                            $grandTotal += $subtotal;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->packageItem->package->nama ?? '-' }}</td>
                            <td>{{ $item->packageItem->nama_item ?? '-' }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ $item->packageItem->satuan ?? '-' }}</td>
                            <td class="text-end">Rp {{ number_format($harga) }}</td>
                            <td class="text-end">Rp {{ number_format($subtotal) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada item laundry.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="6" class="text-end">Total Item Laundry:</th>
                        <th class="text-end">Rp {{ number_format($grandTotal) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- LAYANAN TAMBAHAN --}}
        <h6 class="fw-semibold mt-3 mb-2">Layanan Tambahan</h6>
        @php $totalLayanan = 0; @endphp
        @if ($transaction->services->count())
            <ul class="small mb-2">
                @foreach ($transaction->services as $service)
                    <li>
                        {{ $service->nama }} (Rp {{ number_format($service->harga) }})
                        @php $totalLayanan += $service->harga; @endphp
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted small fst-italic">Tidak ada layanan tambahan.</p>
        @endif

        {{-- TOTAL --}}
        <table class="table table-sm small mt-2 w-100">
            <tr>
                <th class="text-end w-75">Total Item Laundry:</th>
                <td class="text-end">Rp {{ number_format($grandTotal) }}</td>
            </tr>
            <tr>
                <th class="text-end">Total Layanan:</th>
                <td class="text-end">Rp {{ number_format($totalLayanan) }}</td>
            </tr>
            <tr class="fw-bold">
                <th class="text-end">Total Keseluruhan:</th>
                <td class="text-end text-primary">Rp {{ number_format($grandTotal + $totalLayanan) }}</td>
            </tr>
        </table>
    </div>
@endsection
