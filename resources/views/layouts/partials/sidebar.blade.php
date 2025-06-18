<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{ url('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Transaksi</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseDeposito" 
                aria-expanded="false" aria-controls="collapseDeposito">
                <div class="sb-nav-link-icon"><i class="fas fa-money-bill"></i></div>
                Deposito
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseDeposito" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('/deposito') }}">
                        <i class="far fa-calendar-check"></i>Deposito Hari Ini
                    </a>
                    <a class="nav-link" href="{{ url('/deposito-lalu') }}">
                        <i class="far fa-calendar-alt"></i>Deposito Yang Lalu
                    </a>
                    <a class="nav-link" href="{{ url('/tujuandepo') }}">
                        <i class="fas fa-arrow-right"></i>Tujuan Deposito
                    </a>
                    <a class="nav-link" href="{{ route('deposito-tanpa-pajak.index') }}">
                        <i class="fas fa-percentage"></i>Bebas Pajak
                    </a>
                </nav>
            </div>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        @auth
            {{ Auth::user()->name }}
            <div class="mt-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        @endauth
    </div>
</nav>

<style>
/* Styling untuk sidebar */
.sb-sidenav {
    background-color: #343a40; /* Warna latar belakang utama */
    color: #ffffff; /* Warna teks */
}

/* Menu heading */
.sb-sidenav-menu-heading {
    padding: 1.25rem 1rem 0.75rem;
    font-size: 0.75rem;
    font-weight: bold;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.7); /* Warna heading lebih terang */
}

/* Link navigasi */
.sb-sidenav-menu .nav-link {
    color: rgba(255, 255, 255, 0.85);
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    transition: background-color 0.2s ease, color 0.2s ease;
}

/* Hover effect untuk link */
.sb-sidenav-menu .nav-link:hover {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.1);
}

/* Active state untuk link */
.sb-sidenav-menu .nav-link.active {
    color: #ffffff;
    background-color: rgba(0, 123, 255, 0.15); /* Warna biru untuk aktif */
}

/* Icon link */
.sb-nav-link-icon {
    margin-right: 0.5rem;
    font-size: 1.1rem; /* Ukuran ikon */
}

/* Footer sidebar */
.sb-sidenav-footer {
    background-color: #343a40;
    padding: 0.75rem;
    font-size: 0.875rem;
}

/* Collapse arrow */
.sb-sidenav-collapse-arrow {
    margin-left: auto;
    transition: transform 0.15s ease;
}

/* Animasi untuk collapse */
.collapse {
    transition: all 0.2s ease-out;
}

/* Hover effect untuk nested items */
.sb-sidenav-menu-nested .nav-link:hover {
    padding-left: 2.25rem !important;
    background-color: rgba(0, 123, 255, 0.1); /* Warna biru untuk nested hover */
}

/* Active state untuk menu */
.nav-link[aria-expanded="true"] {
    background-color: rgba(0, 123, 255, 0.05); /* Warna biru untuk expanded */
}
</style>
