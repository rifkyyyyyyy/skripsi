<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Sidebar Toggle Example</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    :root {
        --bg-color: #f4f7fe;
        --primary-color: #4318FF; /* Vibrant modern blue/purple */
        --primary-hover: #3311db;
        --sidebar-bg: #11047A; /* Deep rich blue */
        --sidebar-text: #ffffff;
        --text-main: #2B3674;
        --text-muted: #A3AED0;
        --card-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    body {
        margin: 0;
        font-family: 'Outfit', sans-serif;
        background: var(--bg-color);
        color: var(--text-main);
        transition: all 0.3s ease;
        overflow-x: hidden;
    }

    /* GLOBAL MODERN STYLES */
    .card-custom {
        width: 100% !important;
        background: var(--card-bg) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border) !important;
        border-radius: 20px !important;
        padding: 28px !important;
        box-shadow: 0 18px 40px rgba(112, 144, 176, 0.12) !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
    }
    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 22px 45px rgba(112, 144, 176, 0.18) !important;
    }

    /* Modals */
    .modal-content {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255,255,255,0.8) !important;
        border-radius: 24px !important;
        box-shadow: 0 25px 50px rgba(0,0,0,0.15) !important;
        overflow: hidden;
    }
    .modal-header {
        border-bottom: 1px solid rgba(0,0,0,0.05) !important;
        background: transparent !important;
        padding: 20px 25px;
        font-weight: 700;
        color: var(--text-main);
    }

    /* Tables */
    .table {
        width: 100% !important;
        min-width: 100% !important;
        color: var(--text-main) !important;
        margin-bottom: 0 !important;
        border-collapse: collapse;
    }
    .table thead th {
        background: #F8FAFC !important;
        color: var(--text-muted) !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #E2E8F0 !important;
        border-top: none !important;
        padding: 16px 20px !important;
        text-align: left !important;
    }
    .table tbody td {
        vertical-align: middle;
        padding: 16px 20px !important;
        border-bottom: 1px solid #F1F5F9;
        font-weight: 500;
        transition: background 0.3s ease;
        text-align: left !important;
        color: var(--text-main);
    }
    .table tbody tr:hover td {
        background: rgba(67, 24, 255, 0.04) !important;
    }
    .table-bordered, .table-bordered td, .table-bordered th {
        border: none !important;
    }

    /* Buttons */
    .btn-custom-primary {
        background: var(--primary-color) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(67, 24, 255, 0.3) !important;
        transition: all 0.3s ease !important;
        text-decoration: none;
        display: inline-block;
    }
    .btn-custom-primary:hover {
        background: var(--primary-hover) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(67, 24, 255, 0.4) !important;
        color: white !important;
    }
    
    .btn-custom-danger {
        background: #E31A1A !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(227, 26, 26, 0.3) !important;
        transition: all 0.3s ease !important;
    }
    .btn-custom-danger:hover {
        background: #c21515 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(227, 26, 26, 0.4) !important;
        color: white !important;
    }
    
    .btn-custom-success {
        background: #01B574 !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 10px 20px !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(1, 181, 116, 0.3) !important;
        transition: all 0.3s ease !important;
    }
    .btn-custom-success:hover {
        background: #009961 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(1, 181, 116, 0.4) !important;
        color: white !important;
    }

    /* Form Inputs */
    .form-control-custom {
        border-radius: 15px !important;
        border: 1px solid #E2E8F0 !important;
        padding: 12px 20px !important;
        color: var(--text-main) !important;
        font-weight: 500 !important;
        background: #F4F7FE !important;
        transition: all 0.3s ease !important;
    }
    .form-control-custom:focus {
        background: #FFFFFF !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1) !important;
    }

    /* Pagination */
    .pagination .page-item .page-link {
        border-radius: 10px;
        margin: 0 4px;
        border: none;
        color: var(--text-muted);
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 4px 10px rgba(67, 24, 255, 0.3);
    }

    /* SIDEBAR */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: var(--sidebar-bg);
        background-image: radial-gradient(circle at top right, #2B169C, var(--sidebar-bg));
        color: var(--sidebar-text);
        display: flex;
        flex-direction: column;
        box-shadow: 5px 0 25px rgba(0,0,0,0.1);
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        z-index: 1000;
    }
    .sidebar.closed {
        width: 0;
    }
    .sidebar .brand {
        padding: 30px 20px 10px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .sidebar .brand img {
        width: 140px;
        border-radius: 12px;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
    }
    .sidebar nav {
        flex: 1;
        padding: 10px 15px;
        overflow-y: auto;
    }
    .sidebar nav::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
    }
    .sidebar nav a {
        display: flex;
        align-items: center;
        gap: 16px;
        color: rgba(255,255,255,0.7);
        padding: 14px 18px;
        margin-bottom: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-size: 16px;
        font-weight: 500;
        border-radius: 14px;
    }
    .sidebar nav a i {
        font-size: 18px;
        width: 24px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    .sidebar nav a:hover {
        background: rgba(255,255,255,0.08);
        color: white;
        transform: translateX(4px);
    }
    .sidebar nav a.active {
        background: var(--primary-color);
        color: white;
        box-shadow: 0 4px 15px rgba(67, 24, 255, 0.4);
    }
    .sidebar nav a:hover i, .sidebar nav a.active i {
        transform: scale(1.1);
    }
    .section-title {
        margin: 25px 18px 10px;
        font-size: 12px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        letter-spacing: 1.5px;
        font-weight: 700;
    }

    /* TOPBAR */
    .topbar {
        height: 90px;
        padding: 0 30px;
        margin-left: 260px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(244, 247, 254, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        position: sticky;
        top: 0;
        z-index: 900;
        border-bottom: 1px solid rgba(255,255,255,0.5);
    }
    .topbar.expanded {
        margin-left: 0;
    }
    .hamburger {
        width: 42px;
        height: 42px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .hamburger div {
        width: 18px;
        height: 2px;
        background: var(--text-main);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .hamburger:hover {
        background: var(--primary-color);
    }
    .hamburger:hover div {
        background: white;
    }
    .logout-button {
        width: 42px;
        height: 42px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: white;
        border: none;
        border-radius: 12px;
        color: #E31A1A;
        font-size: 18px;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .logout-button:hover {
        background: #E31A1A;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(227, 26, 26, 0.2);
    }
    #main-content {
        margin-left: 260px;
        padding: 30px;
        transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: calc(100vh - 90px);
    }
    #main-content.expanded {
        margin-left: 0;
    }
    .topbar-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .system-title {
        display: flex;
        flex-direction: column;
    }
    .system-title h1 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }
    .system-title p {
        margin: 0;
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
    }
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .admin-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 8px 15px 8px 8px;
        border-radius: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .admin-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary-color);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }
    .admin-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-main);
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .sidebar.closed {
            width: 260px; /* override desktop close behavior */
        }
        .topbar, #main-content {
            margin-left: 0;
        }
        #main-content {
            padding: 15px;
        }
        .topbar {
            padding: 0 15px;
            height: 70px;
        }
        .topbar.expanded, #main-content.expanded {
            margin-left: 0;
        }
        .system-title h1 {
            font-size: 16px;
        }
        .system-title p {
            font-size: 12px;
        }
        .admin-name {
            display: none;
        }
        .brand img {
            width: 120px;
        }
    }
</style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <div class="sidebar" id="sidebar">
        
        <div class="brand">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo">
        </div>

        <nav>
            <div class="section-title">Home</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>            
            
            <div class="section-title">Produk</div>
            <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i> Data Produk
            </a>            
            
            <div class="section-title">Penjualan</div>
            <a href="{{ route('penjualan.index') }}" class="{{ request()->is('penjualan*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Data Penjualan
            </a>        
            
            <div class="section-title">Prediksi</div>
            <a href="/prediksi" class="{{ request()->is('prediksi*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Double Exp. Smoothing
            </a>
            
            <div class="section-title">History</div>
            <a href="{{ route('history.index') }}" class="{{ request()->is('history') ? 'active' : '' }}">
                <i class="fas fa-history"></i> History Prediksi
            </a>
        </nav>
    </div>

    <div class="topbar" id="topbar">
        <div class="topbar-left">
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
                <div class="admin-avatar">A</div>
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
        const sidebarOverlay = document.getElementById('sidebar-overlay');
    
        // 🔹 Sidebar toggle
        hamburger.addEventListener('click', () => {
            if (window.innerWidth <= 992) {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('closed');
                topbar.classList.toggle('expanded');
                mainContent.classList.toggle('expanded');
            }
        });

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('show');
            });
        }
    
    
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
