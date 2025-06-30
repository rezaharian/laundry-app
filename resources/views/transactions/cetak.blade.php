<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi - Laundream</title>
    <style>
        body {
            font-family: "Courier New", monospace;
            font-size: 10px;
            margin: 8px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
        }

        .header p {
            margin: 1px 0;
            font-size: 9px;
        }

        hr {
            border: none;
            border-top: 1px dashed #444;
            margin: 6px 0;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        thead th {
            border-bottom: 1px solid #000;
            font-size: 9px;
            text-align: left;
            padding: 3px 0;
        }

        tbody td {
            font-size: 9px;
            padding: 2px 0;
            border-bottom: 1px dashed #ccc;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .total-box {
            margin-top: 6px;
            padding: 4px;
            border-top: 1px dashed #444;
        }

        .total-box p {
            margin: 2px 0;
        }

        ul {
            margin: 2px 0 5px 14px;
            padding: 0;
            font-size: 9px;
        }

        li {
            margin: 2px 0;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laundream</h2>
        <p><em>"Cucian beres, lanjutkan mimpi."</em></p>
        <p>Jl. Pahlawan No. 99, Pacitan</p>
        <p>Telp. 0897-7665-58777</p>
    </div>

    <hr>

    <div class="info">
        <p><strong>Customer:</strong> {{ $transaction->pelanggan_nama }}</p>
        <p><strong>Petugas:</strong> {{ $transaction->user->name }}</p>
        <p><strong>Tgl Masuk:</strong> {{ \Carbon\Carbon::parse($transaction->tanggal_masuk)->format('d M Y') }}</p>
        <p><strong>Tgl Keluar:</strong>
            {{ $transaction->tanggal_keluar ? \Carbon\Carbon::parse($transaction->tanggal_keluar)->format('d M Y') : '-' }}
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($transaction->items as $item)
                @php
                    $harga = $item->packageItem->harga ?? 0;
                    $subtotal = $item->jumlah * $harga;
                    $grandTotal += $subtotal;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->packageItem->nama_item ?? '-' }}</td>
                    <td class="text-center">{{ number_format($item->jumlah) }}</td>
                    <td class="text-end">Rp {{ number_format($harga) }}</td>
                    <td class="text-end">Rp {{ number_format($subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="fw-bold mt-2">Layanan Tambahan:</p>
    @php $totalLayanan = 0; @endphp
    <ul>
        @forelse ($transaction->services as $service)
            <li>{{ $service->nama }} (Rp {{ number_format($service->harga) }})</li>
            @php $totalLayanan += $service->harga; @endphp
        @empty
            <li><em>Tidak ada layanan tambahan</em></li>
        @endforelse
    </ul>

    <div class="total-box">
        <p><strong>Total Item Laundry:</strong> Rp {{ number_format($grandTotal) }}</p>
        <p><strong>Total Layanan:</strong> Rp {{ number_format($totalLayanan) }}</p>
        <p class="fw-bold"><strong>Total Keseluruhan:</strong> Rp {{ number_format($grandTotal + $totalLayanan) }}</p>
    </div>

    <hr>

    <div class="footer">
        <p>{{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
        <p>Petugas: {{ $transaction->user->name }}</p>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
