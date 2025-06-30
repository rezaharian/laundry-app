@extends('layouts.apptr')

@section('content')
    <style>
        .text-tosca {
            color: #4fd1c5 !important;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 0.75rem;
            border: none;
            transition: all 0.2s ease-in-out;
            min-height: 80px;
            /* ✅ Lebih kecil */
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .bg-gradient-blue {
            background: linear-gradient(135deg, #b2ebf2, #4dd0e1);
            --icon-color: #007b8a;
        }

        .bg-gradient-green {
            background: linear-gradient(135deg, #c8e6c9, #81c784);
            --icon-color: #2e7d32;
        }

        .bg-gradient-yellow {
            background: linear-gradient(135deg, #fff59d, #ffd54f);
            --icon-color: #f57f17;
        }

        .bg-gradient-pink {
            background: linear-gradient(135deg, #f8bbd0, #f06292);
            --icon-color: #c2185b;
        }

        .icon-style {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.25);
            color: var(--icon-color);
        }

        .fs-sm {
            font-size: 0.75rem;
        }

        .fw-medium {
            font-weight: 500;
        }

        .fs-6 {
            font-size: 0.875rem !important;
        }
    </style>


    {{-- TAMPILAN HEADER --}}
    <div class="text-center mb-4">
        <h4 class="fw-semibold text-tosca mt-3 mb-0">
            Selamat Datang di
            <span class="text-dark">
                <img src="{{ asset('logo-laundream.png') }}" alt="Logo" height="50">
            </span>
        </h4>
        <p class="text-muted small">Aplikasi Kelola layanan, paket, dan transaksi laundry dengan mudah dan efisien.</p>
    </div>

    {{-- MENU ATAS --}}
    @php
        $menus = [
            [
                'icon' => 'fas fa-receipt',
                'route' => 'transactions.index',
                'title' => 'Transaksi',
                'desc' => 'Kelola data transaksi',
                'bg' => 'bg-gradient-blue',
            ],
            [
                'icon' => 'fas fa-box',
                'route' => 'packages.index',
                'title' => 'Paket',
                'desc' => 'Kelola jenis paket laundry',
                'bg' => 'bg-gradient-green',
            ],
            [
                'icon' => 'fas fa-tags',
                'route' => 'package-items.index',
                'title' => 'Item Paket',
                'desc' => 'Kelola item dalam paket',
                'bg' => 'bg-gradient-yellow',
            ],
            [
                'icon' => 'fas fa-concierge-bell',
                'route' => 'services.index',
                'title' => 'Layanan',
                'desc' => 'Kelola jenis layanan',
                'bg' => 'bg-gradient-pink',
            ],
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach ($menus as $menu)
            <div class="col-6 col-md-3">
                <a href="{{ route($menu['route']) }}" class="text-decoration-none">
                    <div class="card glass-card {{ $menu['bg'] }} text-white h-100">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="icon-style me-3">
                                <i class="{{ $menu['icon'] }}"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $menu['title'] }}</div>
                                <div class="fs-sm fw-medium">{{ $menu['desc'] }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- STATISTIK --}}
    <p class="fw-semibold text-secondary mt-4 mb-3">
        Statistik Hari Ini — {{ \Carbon\Carbon::now()->format('d M Y') }} :
    </p>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <div class="card glass-card bg-gradient-blue text-white h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon-style me-3"><i class="fas fa-file-invoice"></i></div>
                    <div>
                        <div class="fw-bold fs-6">{{ $jumlahTransaksi }}</div>
                        <div class="fs-sm">Transaksi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card glass-card bg-gradient-green text-white h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon-style me-3"><i class="fas fa-boxes"></i></div>
                    <div>
                        <div class="fw-bold fs-6">{{ number_format($jumlahItem, 0, ',', '.') }}</div>
                        <div class="fs-sm">Item</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card glass-card bg-gradient-yellow text-white h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon-style me-3"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="fw-bold fs-6">{{ $jumlahOrang }}</div>
                        <div class="fs-sm">Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card glass-card bg-gradient-pink text-white h-100">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="icon-style me-3"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <div class="fw-bold fs-6">Rp {{ number_format($jumlahRupiah, 0, ',', '.') }}</div>
                        <div class="fs-sm">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
