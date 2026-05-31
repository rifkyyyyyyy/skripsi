@extends('layout.sidebar')

@section('content')
<style>

    /* ===============================
       LIGHT MODE (DEFAULT)
    =============================== */
    :root {
        --card-bg: #ffffff;
        --text-color: #333;
        --table-border: #dddddd;
        --table-header-bg: #f0f0f0;
        --input-bg: #ffffff;
        --input-border: #cccccc;
    }
    
    /* ===============================
       DARK MODE
    =============================== */
    body.dark {
        --card-bg: #334155;
        --text-color: #e2e8f0;
        --table-border: #ffffff;
        --table-header-bg: #475569;
        --input-bg: #334155;
        --input-border: #94a3b8;
    }
    
    /* ===============================
    LAYOUT
    =============================== */
    .produk-container {
        margin-top: 35px;
        padding: 0 25px 40px;
        font-family: 'Inter', sans-serif;
    }

    /* ===============================
    CARD
    =============================== */
    .produk-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.06);
        color: var(--text-color);
        overflow: hidden;
    }

    .produk-card h3 {
        margin-bottom: 25px;
        font-size: 22px;
        font-weight: 700;

        background: linear-gradient(135deg, #304c89, #4361ee);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    .title-wrapper{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:25px;
    }

    .total-badge{
        background: #8b8ba0;
        color: white;
        padding: 6px 14px;
        border-radius: 7px;
        font-size: 16px;
        font-weight: 700;
        line-height: 1;
    }

    body.dark .total-badge{
        background:#475569;
        color:#f1f5f9;
    }

    body.dark .produk-card h3{
        color: #e2e8f0;
    }

    /* ===============================
    TOP CONTROL
    =============================== */
    .top-control{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding-bottom: 22px;
        margin-bottom: 0px;
        flex-wrap: wrap;
        gap: 15px;
        border-bottom:1px solid #e2e8f0;
    }

    body.dark .top-control{
        border-bottom:1px solid #64748b;
    }
    .entries-control select {
        width: 100%;
        height: 40px;
        padding: 0 40px 0 14px;
        border-radius: 7px;
        font-size: 15px;
        border: 1px solid #dbe2ea;
        background: #ffffff !important;
        color: #8c929b !important;
        outline: none;
        font-weight: 500;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
    }
    .entries-control{
        position: relative;
        display: inline-block;
    }

    /* PANAH ATAS */
        .entries-control::before{
            content: "";
            position: absolute;
            right: 20px;
            top: 13px;
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 5px solid #9ca3af;

            pointer-events: none;
        }

        /* PANAH BAWAH */
        .entries-control::after{
            content: "";
            position: absolute;
            right: 20px;
            bottom: 13px;
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid #9ca3af;

            pointer-events: none;
        }

    body.dark .entries-control select{
        border:1px solid #64748b;
    }

    /* ===============================
    BUTTONS
    =============================== */
    .button-group{
        display:flex;
        gap:12px;
    }

    .import,
    .input-manual{
        border:none;
        border-radius:7px;
        padding:12px 20px;
        font-size:15px;
        font-weight:600;
        color:white;
        display:flex;
        align-items:center;
        gap:8px;
        transition:0.3s;
        cursor:pointer;
    }

    .import{
        background:linear-gradient(135deg, #304c89, #4361ee);
    }

    .import:hover{
        background:linear-gradient(135deg, #4361ee, #304c89);
        transform:translateY(-2px);
    }

    .input-manual{
        background:#22c55e;
    }

    .input-manual:hover{
        background:#16a34a;
        transform:translateY(-2px);
    }

    /* ===============================
    TABLE WRAPPER
    =============================== */
    .table-wrapper{
        width:100%;
        overflow-x:auto;
    }

    /* ===============================
    TABLE
    =============================== */
    .produk-table{
        width:100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .produk-table thead th{
        padding:20px 18px;
        font-size:15px;
        font-weight:700;
        color:#3b4e71;
        background:#f8fafc;
        border-bottom:3px solid #e2e8f0;
        text-align:center;
    }

    body.dark .produk-table thead th{
        background:#475569;
        color:#f1f5f9;
        border-bottom:2px solid #64748b;
    }

    .produk-table tbody td{
        padding:22px 18px;
        border-bottom:1px solid #e5e7eb;
        font-size:15px;
        font-weight:500;
        color:#6b7280;
        text-align:center;
    }

    body.dark .produk-table tbody td{
        border-bottom:1px solid #64748b;
        color:#e2e8f0;
    }

    .produk-table tbody tr{
        transition:0.25s;
    }

    .produk-table tbody tr:hover{
        background:#f8fafc;
    }

    body.dark .produk-table tbody tr:hover{
        background:#3f4c61;
    }

     /* ===============================
    TABLE COLUMN SIZE
    =============================== */
    .produk-table th:nth-child(1),
    .produk-table td:nth-child(1){
        width: 80px;
    }

    .produk-table th:nth-child(2),
    .produk-table td:nth-child(2){
        width: 180px;
    }

    .produk-table th:nth-child(3),
    .produk-table td:nth-child(3){
        width: 100px;
        text-align: left;
        padding-left: 100px;
    }

    .produk-table th:nth-child(4),
    .produk-table td:nth-child(4){
        width: 100px;
    }

    .produk-table th:nth-child(5),
    .produk-table td:nth-child(5){
        width: 150px;
    }
    /* ===============================
    SUCCESS ALERT
    =============================== */
    .alert-success{
        background:#dcfce7;
        color:#166534;
        padding:14px 18px;
        border-radius:12px;
        margin-bottom:20px;
        font-weight:600;
    }

    body.dark .alert-success{
        background:#14532d;
        color:#dcfce7;
    }
    
    /* ===============================
       MODAL
    =============================== */
    .modal {
        visibility: hidden;
        opacity: 0;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0,0,0,0.4);
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal.show {
        visibility: visible;
        opacity: 1;
    }
    
    .modal-content {
        background-color: var(--card-bg);
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 600px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        opacity: 0;
        transform: scale(0.8);
        transition: transform 0.35s ease, opacity 0.35s ease;
        color: var(--text-color);
    }
    .modal.show .modal-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .modal-header {
        background: linear-gradient(135deg, #304c89, #4361ee);
        color: #ffffff;
        padding: 18px 20px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-size: 24px;
        font-weight: 600;
    }
    
    .modal-body {
        padding: 20px;
    }
    .modal-body input {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border-radius: 6px;
        border: 1px solid var(--input-border);
        background: var(--input-bg);
        color: var(--text-color);
        font-size: 14px;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid var(--table-border);
    }
    .modal-footer button {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .modal-footer .btn-close {
        background-color: #6c757d;
        color: white;
        font-size: 16px;
    }
    .modal-footer .btn-close:hover {
        background-color: #5a6268;
    }
    .modal-footer .btn-save {
        background: linear-gradient(135deg, #304c89, #4361ee);
        color: white;
        font-weight: 700;
        font-size: 16px;
    }
    .modal-footer .btn-save:hover {
        background-color: #0056b3;
    }
    
    /* INPUT inside modal (special width) */
    .modal-body .form-control {
        width: 500px;
        display: inline-block;
        margin-top: 10px;
    }
    
     .search-box{
    position: relative;
    margin-left: -450px;
}

.search-box input{
    width: 300px;
    height: 40px;

    border-radius: 7px;
    border: 1px solid #dbe2ea;

    padding-left: 40px;
    padding-right: 15px;

    font-size: 14px;
    background: #fff;

    transition: .3s;
}

.search-box input:focus{
    outline: none;
    border-color: #4361ee;
    box-shadow: 0 0 0 4px rgba(67,97,238,.12);
}

.search-box i{
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

body.dark .search-box input{
    background: #334155;
    color: #fff;
    border-color: #64748b;
}
</style>
    


<div class="produk-container">
    <div class="produk-card">
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
            <div class="entries-control">
                <form method="GET" action="{{ route('produk.index') }}" id="filterForm">
                    <select name="filter" id="entriesPerPage" onchange="document.getElementById('filterForm').submit()">
                        <option value="20_terbaru" {{ $filter == '20_terbaru' ? 'selected' : '' }}>20 Terbaru</option>
                        <option value="7_hari" {{ $filter == '7_hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="1_bulan" {{ $filter == '1_bulan' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                        <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Produk</option>
                    </select>
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
            <div class="button-group" style="display:flex; gap:10px;">
                <button class="input-manual" id="openModal">
                    <i class="fas fa-plus-circle"></i> Input Produk
                </button>

                <form action="{{ route('produk.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
                    @csrf
                    <label for="fileInput" class="import">
                        <i class="fas fa-file-import"></i> Import
                    </label>
                    <input type="file" id="fileInput" name="file" accept=".csv, .xlsx" style="display:none;" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="produk-table" id="produkTable">
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
<div id="inputModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Input Produk</div>
        <div class="modal-body">
            <form id="produkForm" action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3"> 
                    <label>Kode Produk</label> 
                    <input type="text" class="form-control" name="kode_produk" placeholder="Input kode produk disini" required> 
                </div> 
                <div class="form-group mb-3"> 
                    <label>Nama Produk</label> 
                    <input type="text" class="form-control" name="nama_produk" placeholder="Input nama produk disini" required>
                </div> 
                <div class="form-group mb-3"> 
                    <label>Stok</label> 
                    <input type="number" class="form-control" name="stok" placeholder="Input stok disini" required>
                </div> 
                <div class="form-group mb-3"> 
                    <label>Tangal</label> 
                    <input type="date" class="form-control" name="tanggal" placeholder="Input tanggal disini" required>
                </div> 
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-close" id="closeModal">Batal</button>
            <button type="submit" form="produkForm" class="btn-save">
                <i class="fas fa-save me-2"></i>
                Simpan 
            </button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("inputModal");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");

    openModal.onclick = () => {
        modal.classList.add("show");
    };

    closeModal.onclick = () => {
        modal.classList.remove("show");
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.classList.remove("show");
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
