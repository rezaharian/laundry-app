<style>
    .navbar .nav-link.active {
        background-color: rgb(255, 255, 255);
        border-radius: 0.5rem;
        color: #048d99 !important;
        font-weight: 600;
    }
</style>

<nav class="navbar navbar-expand-lg shadow-sm" style="background: linear-gradient(to right, #49e2ef, #40d4dc);">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('logo-laundream.png') }}" alt="Logo" height="60"
                style="filter: brightness(0) invert(1);">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link text-white {{ request()->is('dashboard*') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('packages.index') }}"
                        class="nav-link text-white {{ request()->is('packages*') ? 'active' : '' }}">
                        Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('package-items.index') }}"
                        class="nav-link text-white {{ request()->is('package-items*') ? 'active' : '' }}">
                        Item Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('services.index') }}"
                        class="nav-link text-white {{ request()->is('services*') ? 'active' : '' }}">
                        Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transactions.index') }}"
                        class="nav-link text-white {{ request()->is('transactions*') ? 'active' : '' }}">
                        Transaksi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
