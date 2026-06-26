@extends('layout.sidebar')

@section('content')
<style>
    .produk-container {
        margin-top: 20px;
        font-family: 'Outfit', sans-serif;
    }
    .title-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .title-wrapper h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: var(--text-main);
    }
    .total-badge {
        background: rgba(67, 24, 255, 0.1);
        color: var(--primary-color);
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
    }
    .top-control {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
        border-bottom: 1px solid var(--glass-border);
    }
    .left-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .entries-select-wrapper {
        position: relative;
        display: inline-block;
    }
    .entries-select-wrapper .entries-chevron {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #A3AED0;
        font-size: 14px;
        pointer-events: none;
    }
    .entries-control select {
        height: 42px;
        padding: 0 40px 0 16px;
        border-radius: 12px;
        font-size: 14px;
        border: 1px solid var(--glass-border);
        background: var(--glass-bg);
        color: var(--text-main);
        outline: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        font-family: 'Outfit', sans-serif;
    }
    .entries-control select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }
    .search-box {
        position: relative;
    }
    .search-box input {
        width: 320px;
        height: 42px;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding-left: 45px;
        padding-right: 15px;
        font-size: 14px;
        background: #F8FAFC;
        transition: all 0.3s ease;
        font-weight: 500;
        color: var(--text-main);
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
        background: #ffffff;
    }
    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #A3AED0;
    }
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }
    .alert-success {
        background: rgba(1, 181, 116, 0.1);
        color: #01B574;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 600;
        border: 1px solid rgba(1, 181, 116, 0.2);
    }
    @media (max-width: 768px) {
        .top-control {
            flex-direction: column;
            align-items: stretch;
        }
        .left-controls, .left-controls .entries-control, .left-controls form, .entries-select-wrapper {
            width: 100%;
        }
        .entries-select-wrapper select {
            width: 100%;
        }
        .search-box {
            width: 100%;
            margin-top: 10px;
        }
        .search-box input {
            width: 100%;
        }
    }
</style>
    


<div class="produk-container">
    <div class="card-custom">
        <div class="title-wrapper">
            <h3>Daftar Produk</h3>

            <div class="total-badge">
                Total : {{ $totalProduk }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-control">
            <div class="left-controls">
                <div class="entries-control">
                    <form method="GET" action="{{ route('produk.index') }}" id="filterForm">
                        <div class="entries-select-wrapper">
                            <select name="filter" id="entriesPerPage" onchange="document.getElementById('filterForm').submit()">
                                <option value="20_terbaru" {{ $filter == '20_terbaru' ? 'selected' : '' }}>20 Terbaru</option>
                                <option value="7_hari" {{ $filter == '7_hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                                <option value="1_bulan" {{ $filter == '1_bulan' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Produk</option>
                            </select>
                            <i class="fas fa-chevron-down entries-chevron"></i>
                        </div>
                    </form>
                </div>
                <!-- SEARCH -->
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari kode, produk, atau bulan..."
                     >
                </div>
            </div>
            <div class="button-group" style="display:flex; gap:10px;">
                <button class="btn-custom-success" id="openModal">
                    <i class="fas fa-plus-circle"></i> Input Produk
                </button>

                <form action="{{ route('produk.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
                    @csrf
                    <label for="fileInput" class="btn-custom-primary" style="cursor: pointer; margin: 0;">
                        <i class="fas fa-file-import"></i> Import
                    </label>
                    <input type="file" id="fileInput" name="file" accept=".csv, .xlsx" style="display:none;" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table" id="produkTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Bulan</th>
                    </tr>
                </thead>
                <tbody id="produkTableBody">
                    @forelse($produks as $index => $produk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $produk->kode_produk }}</td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>{{ \Carbon\Carbon::parse($produk->bulan)->translatedFormat('F Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>        
        </div>
    </div>
</div>

<!-- Modal Input Produk -->
<div id="inputModal" class="modal" tabindex="-1" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 1050; justify-content: center; align-items: center;">
    <div class="modal-content" style="width: 100%; max-width: 500px; margin: auto; position: relative;">
        <div class="modal-header">
            <h5 style="margin: 0;">Input Produk</h5>
        </div>
        <div class="modal-body p-4">
            <form id="produkForm" action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="form-group mb-4"> 
                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Kode Produk</label> 
                    <input type="text" class="form-control-custom w-100" name="kode_produk" placeholder="Input kode produk disini" required> 
                </div> 
                <div class="form-group mb-4"> 
                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Nama Produk</label> 
                    <input type="text" class="form-control-custom w-100" name="nama_produk" placeholder="Input nama produk disini" required>
                </div> 
                <div class="form-group mb-4"> 
                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Stok</label> 
                    <input type="number" class="form-control-custom w-100" name="stok" placeholder="Input stok disini" required>
                </div> 
                <div class="form-group mb-4"> 
                    <label style="font-weight: 600; margin-bottom: 8px; display: block;">Tangal</label> 
                    <input type="date" class="form-control-custom w-100" name="tanggal" placeholder="Input tanggal disini" required>
                </div> 
            </form>
        </div>
        <div class="modal-footer" style="padding: 20px; border-top: 1px solid rgba(0,0,0,0.05);">
            <button class="btn btn-secondary" id="closeModal" style="border-radius: 12px; font-weight: 600; padding: 10px 20px;">Batal</button>
            <button type="submit" form="produkForm" class="btn-custom-primary">
                <i class="fas fa-save me-2"></i> Simpan 
            </button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("inputModal");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");

    openModal.onclick = () => {
        modal.style.display = "flex";
        setTimeout(() => { modal.style.opacity = "1"; }, 10);
    };

    closeModal.onclick = (e) => {
        e.preventDefault();
        modal.style.opacity = "0";
        setTimeout(() => { modal.style.display = "none"; }, 300);
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.opacity = "0";
            setTimeout(() => { modal.style.display = "none"; }, 300);
        }
    };
</script>

<script>
const searchInput = document.getElementById('searchInput');

searchInput.addEventListener('keyup', function() {

    const keyword = this.value.toLowerCase();

    const rows = document.querySelectorAll(
        '#penjualanTable tbody tr'
    );

    rows.forEach(row => {

        const kodeProduk =
            row.cells[1]?.textContent.toLowerCase() || '';

        const namaProduk =
            row.cells[2]?.textContent.toLowerCase() || '';

        const bulan =
            row.cells[4]?.textContent.toLowerCase() || '';

        if (
            kodeProduk.includes(keyword) ||
            namaProduk.includes(keyword) ||
            bulan.includes(keyword)
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});
</script>

@endsection
