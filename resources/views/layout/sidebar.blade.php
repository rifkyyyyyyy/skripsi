<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sidebar Toggle Example</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
<style>
    :root {
        --bg-color: #f1f1f1;
        --sidebar-bg: linear-gradient(135deg, #304c89, #4361ee);
        --sidebar-text: #fff;
        --sidebar-hover: rgba(255,255,255,0.1);
        --section-title: #94a3b8;
        --topbar-text: #3b4e71;
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background: var(--bg-color);
        color: var(--topbar-text);
        transition: all 0.3s ease;
        overflow-x: hidden;
    }
    .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 90vh;
    width: 240px;
    margin-top: 100px;
    /* GRADIENT BARU */
    background: linear-gradient(
        180deg,
        #304c89 0%,
        #3d57b3 45%,
        #4966f0 100%
    );

    color: var(--sidebar-text);
    display: flex;
    flex-direction: column;

    box-shadow: 15px 0 20px rgba(0,0,0,0.15);

    transition: width 0.3s ease;
    overflow: hidden;
    z-index: 800;
}
    .sidebar.closed {
        width: 0;
    }
    .sidebar .brand {
        font-size: 20px;
        font-weight: 600;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom:none;
        white-space: nowrap;
    }
    .sidebar nav {
        flex: 1;
        padding: 10px 0;
        overflow: hidden;
        transition: opacity 0.3s ease;
    }
    .sidebar.closed nav {
        opacity: 0;
        pointer-events: none;
    }
    .sidebar nav a {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #ffffff;
        padding: 14px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-size: 17px;
        font-weight: 500;
    }
    .sidebar nav a:hover,
    .sidebar nav a.active {
        background: rgba(255,255,255,0.12);
        border-left: 4px solid #ffffff;
        padding-left: 16px;
        color: #fff;
    }
    .section-title {
        margin: 50px 20px 10px;
        font-size: 12px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        letter-spacing: 2px;
        white-space: nowrap;
        font-weight: 600;
    }
    .topbar {
        height: 100px;
        padding: 0 30px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        transition: margin-left 0.3s ease;

        /* HEADER PUTIH */
        background: #ffffff;

        border-bottom: 1px solid #e5e7eb;

        box-shadow: 0 2px 12px rgba(0,0,0,0.05);

        position: sticky;
        top: 0;
        z-index: 900;
    }
    .topbar.expanded {
        margin-left: 0;
    }
   .hamburger {
    width: 45px;
    height: 45px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;

    cursor: pointer;

    background: rgba(59, 78, 113, 0.08); /* warna pudar */
    border: 1px solid rgba(59, 78, 113, 0.12);

    border-radius: 12px;

    transition: all 0.3s ease;

    flex-shrink: 0;
}
 .hamburger div {
    width: 18px;
    height: 2px;

    background: var(--topbar-text);

    border-radius: 10px;

    transition: all 0.3s ease;
}
.hamburger:hover {
    background: rgba(59, 78, 113, 0.15);
    transform: translateY(-1px);
}

    .logout-button{
    width: 45px;
    height: 45px;

    display: flex;
    justify-content: center;
    align-items: center;

    background: rgba(59, 78, 113, 0.08);
    border: 1px solid rgba(59, 78, 113, 0.12);

    border-radius: 12px;

    color: var(--topbar-text);
    font-size: 18px;
    cursor: pointer;

    transition: all 0.3s ease;
}

.logout-button:hover{
    background: rgba(59, 78, 113, 0.15);
    transform: translateY(-1px);
}
    #main-content {
        margin-left: 240px;
        padding: 20px;
        transition: margin-left 0.3s ease;
    }
    #main-content.expanded {
        margin-left: 0;
    }

    .topbar-left{
    display: flex;
    align-items: center;
    gap: 150px;
}

.system-title{
    display: flex;
    flex-direction: column;
    line-height: 1.1;
}

.system-title h1{
    margin: 0;
    font-size: 20px;
    font-weight: 800;
    color: #1f2340;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-left:-130px;
}

.system-title p{
    margin: 0;
    margin-top: 4px;
    font-size: 14px;
    color: #7b7b7b;
    font-weight: 500;
    margin-left:-130px;
}

.topbar-right{
    display: flex;
    align-items: center;
    gap: 20px;
}

.admin-info{
    display: flex;
    align-items: center;
    gap: 18px;
}

.admin-info::before{
    content: "";
    width: 1px;
    height: 45px;
    background: #d9dde5;
    display: block;
}

.admin-name{
    font-size: 18px;
    font-weight: 500;
    color: #1e3eb3;
    white-space: nowrap;
}
    
    .sidebar nav a.menu-border {
    position: relative;
    margin-bottom: 25px;
    font-size: 16px;
}

.sidebar nav a.menu-border::after {
    content: "";
    position: absolute;
    left: 20px;      /* jarak dari kiri */
    right: 20px;     /* jarak dari kanan */
    bottom: -10px;   /* turun ke bawah */
    height: 2px;
    background: rgba(3, 21, 150, 0.12);
    border-radius: 10px;
}
</style>
</head>
<body>

    <div class="sidebar" id="sidebar">

        <nav>

            <div class="section-title">Home</div>
            <a href="{{ route('dashboard') }}" 
                class="menu-border {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>            
            <div class="section-title">Produk</div>
            <a href="{{ route('produk.index') }}" 
                class="menu-border {{ request()->is('produk*') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Data Produk
            </a>            
            <div class="section-title">Penjualan</div>
            <a href="{{ route('penjualan.index') }}" 
                class="menu-border {{ request()->is('penjualan*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Data Penjualan
            </a>        
            <div class="section-title">Prediksi</div>
            <a href="/prediksi" 
                class="menu-border {{ request()->is('prediksi*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Double Exp. Smoothing
            </a>
            
            <div class="section-title">History</div>
            <a href="{{ route('history.index') }}"
                class="menu-border {{ request()->is('history') ? 'active' : '' }}">
                <i class="fas fa-history"></i> History Prediksi
            </a>
        </nav>
    </div>

    <div class="topbar" id="topbar">
        <div class="topbar-left">

            <img src="{{ asset('gambar/logo.png') }}"
                alt="Logo"
                style="width:100px;">

            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="system-title">
                <h1>SISTEM PREDIKSI PENJUALAN</h1>
                <p>Toko Fofee</p>
            </div>

        </div>
            <div class="topbar-right">

                <div class="admin-info">
                    <span class="admin-name">Admin Fofee</span>
                </div>

                <button type="button" class="logout-button" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>

            </div>
    </div>

    <div id="main-content">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>        
        @yield('content')
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('main-content');
    
        // 🔹 Sidebar toggle
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
            topbar.classList.toggle('expanded');
            mainContent.classList.toggle('expanded');
        });
    
    
        // 🔹 Highlight menu aktif (klik + otomatis berdasar URL)
        const navLinks = document.querySelectorAll('.sidebar nav a');
        const currentPath = window.location.pathname;
    
        navLinks.forEach(link => {
            // jika URL sekarang sama dengan href menu → tandai aktif
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
    
            // jika diklik → hapus semua active, lalu aktifkan yang ini
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
           // 🔥 ROUTE LOGOUT
    document.querySelector('.logout-button').addEventListener('click', function () {
        document.getElementById('logout-form').submit();
    });
    </script>
</body>
</html>
