@extends('layouts.apptr')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">Tambah Transaksi Laundry</h2>

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="row g-3 mb-2 align-items-end">
                <div class="col-md-6">
                    <label for="customer_name" class="form-label fw-semibold">Nama Customer</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control"
                        placeholder="Masukkan nama pelanggan" required>
                </div>

                <div class="col-md-3">
                    <label for="tanggal_masuk" class="form-label fw-semibold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                        value="{{ date('Y-m-d') }}" required>
                </div>


                <div class="col-md-3">
                    <label for="tanggal_keluar" class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control">
                </div>
            </div>






            <h5>Item Laundry</h5>
            <div id="item-container">
                <div class="row mb-2 item-row">
                    <div class="col-md-3">
                        <select name="items[0][item_id]" class="form-control item-select" data-index="0" required>
                            <option value="">-- Pilih Item --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                    {{ $item->package->nama }} - {{ $item->nama_item }} ({{ $item->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[0][qty]" class="form-control qty-input" placeholder="Qty"
                            data-index="0" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control harga-input" value="0" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control subtotal-input" value="0" readonly>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                    </div>
                </div>
            </div>
            <button type="button" id="add-item" class="btn btn-secondary mb-3">+ Tambah Item</button>

            <h5>Layanan Tambahan</h5>
            @php $totalService = 0; @endphp
            @foreach ($services as $service)
                <div class="form-check">
                    <input class="form-check-input service-checkbox" type="checkbox" name="services[]"
                        value="{{ $service->id }}" data-harga="{{ $service->harga }}" id="svc{{ $service->id }}">
                    <label class="form-check-label" for="svc{{ $service->id }}">
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

            <div class="mt-3">
                <button class="btn btn-success">Simpan Transaksi</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;

        const itemContainer = document.getElementById('item-container');

        document.getElementById('add-item').addEventListener('click', function() {
            let html = `
        <div class="row mb-2 item-row">
            <div class="col-md-3">
                <select name="items[${itemIndex}][item_id]" class="form-control item-select" data-index="${itemIndex}" required>
                    <option value="">-- Pilih Item --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                            {{ $item->package->nama }} - {{ $item->nama_item }} ({{ $item->satuan }})
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
                <button type="button" class="btn btn-danger btn-remove">Hapus</button>
            </div>
        </div>`;
            itemContainer.insertAdjacentHTML('beforeend', html);
            itemIndex++;
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select') || e.target.classList.contains('qty-input')) {
                updateSubtotals();
            }

            if (e.target.classList.contains('service-checkbox')) {
                updateSubtotals();
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.item-row').remove();
                updateSubtotals();
            }
        });

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
    </script>
@endsection
