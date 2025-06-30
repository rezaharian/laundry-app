@extends('layouts.apptr')

@section('content')
    @php
        $itemHarga = [];
        foreach ($packageItems as $it) {
            $itemHarga[$it->id] = $it->harga;
        }
    @endphp

    <div class="container py-4">
        <h2 class="mb-3">Edit Transaksi</h2>

        <a href="{{ route('transactions.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-2 align-items-end">
                <div class="col-md-6">
                    <label for="pelanggan_nama" class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" name="pelanggan_nama" id="pelanggan_nama" class="form-control"
                        value="{{ old('pelanggan_nama', $transaction->pelanggan_nama) }}" required>
                </div>

                <div class="col-md-3">
                    <label for="tanggal_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                        value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($transaction->tanggal_masuk)->format('Y-m-d')) }}"
                        required>
                </div>

                <div class="col-md-3">
                    <label for="tanggal_keluar" class="form-label fw-semibold">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control"
                        value="{{ old('tanggal_keluar', $transaction->tanggal_keluar ? \Carbon\Carbon::parse($transaction->tanggal_keluar)->format('Y-m-d') : '') }}">
                </div>
            </div>



            <hr>
            <h5>Item Laundry</h5>

            <div id="item-container">
                @foreach ($transaction->items as $i => $item)
                    <div class="row mb-2 item-row">
                        <div class="col-md-3">
                            <select name="items[{{ $i }}][item_id]" class="form-control item-select"
                                data-index="{{ $i }}" required>
                                <option value="">Pilih Item</option>
                                @foreach ($packageItems as $pItem)
                                    <option value="{{ $pItem->id }}" data-harga="{{ $pItem->harga }}"
                                        @selected($item->package_item_id == $pItem->id)>
                                        {{ $pItem->package->nama }} - {{ $pItem->nama_item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[{{ $i }}][qty]" class="form-control qty-input"
                                data-index="{{ $i }}" value="{{ $item->jumlah }}" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control harga-input" value="{{ $item->packageItem->harga }}"
                                readonly>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control subtotal-input"
                                value="{{ $item->jumlah * $item->packageItem->harga }}" readonly>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-item">+ Tambah Item</button>

            <hr>
            <h5>Layanan Tambahan</h5>

            @foreach ($services as $service)
                <div class="form-check">
                    <input class="form-check-input service-checkbox" type="checkbox" name="service_ids[]"
                        value="{{ $service->id }}" data-harga="{{ $service->harga }}" id="service{{ $service->id }}"
                        {{ in_array($service->id, $transaction->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="service{{ $service->id }}">
                        {{ $service->nama }} (Rp {{ number_format($service->harga) }})
                    </label>
                </div>
            @endforeach

            <hr>
            <div class="text-end">
                <p><strong>Total Item Laundry:</strong> Rp <span id="totalLaundry">0</span></p>
                <p><strong>Total Layanan:</strong> Rp <span id="totalService">0</span></p>
                <p class="fs-5"><strong>Total Keseluruhan:</strong> Rp <span id="grandTotal">0</span></p>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script>
        let itemIndex = {{ $transaction->items->count() }};
        const hargaMap = @json($itemHarga);

        function updateSubtotals() {
            let totalLaundry = 0;

            document.querySelectorAll('.item-row').forEach(row => {
                let select = row.querySelector('.item-select');
                let qtyInput = row.querySelector('.qty-input');
                let hargaInput = row.querySelector('.harga-input');
                let subtotalInput = row.querySelector('.subtotal-input');

                let harga = parseInt(select.selectedOptions[0]?.getAttribute('data-harga') || 0);
                let qty = parseInt(qtyInput.value || 0);
                let subtotal = harga * qty;

                hargaInput.value = harga.toLocaleString();
                subtotalInput.value = subtotal.toLocaleString();
                totalLaundry += subtotal;
            });

            let totalService = 0;
            document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
                totalService += parseInt(cb.getAttribute('data-harga'));
            });

            document.getElementById('totalLaundry').textContent = totalLaundry.toLocaleString();
            document.getElementById('totalService').textContent = totalService.toLocaleString();
            document.getElementById('grandTotal').textContent = (totalLaundry + totalService).toLocaleString();
        }

        document.getElementById('add-item').addEventListener('click', function() {
            let html = `
        <div class="row mb-2 item-row">
            <div class="col-md-3">
                <select name="items[${itemIndex}][item_id]" class="form-control item-select" data-index="${itemIndex}" required>
                    <option value="">Pilih Item</option>
                    @foreach ($packageItems as $pItem)
                        <option value="{{ $pItem->id }}" data-harga="{{ $pItem->harga }}">
                            {{ $pItem->package->nama }} - {{ $pItem->nama_item }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="items[${itemIndex}][qty]" class="form-control qty-input" data-index="${itemIndex}" placeholder="Qty" required>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control harga-input" value="0" readonly>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control subtotal-input" value="0" readonly>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button>
            </div>
        </div>`;
            document.getElementById('item-container').insertAdjacentHTML('beforeend', html);
            itemIndex++;
            updateSubtotals();
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select') || e.target.classList.contains('qty-input') || e.target
                .classList.contains('service-checkbox')) {
                updateSubtotals();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
                updateSubtotals();
            }
        });

        document.addEventListener('DOMContentLoaded', updateSubtotals);
    </script>
@endsection
