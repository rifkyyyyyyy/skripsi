@extends('layout.sidebar')

@section('content')
<style>
    /* --- PERAPIHAN TAMPILAN GLOBAL HALAMAN INI --- */
    .section-title-penjualan {
        font-weight: bold;
        margin-top: 30px;
        margin-bottom: 15px;
        color: #304c89; 
        border-left: 5px solid #304c89; 
        padding-left: 10px;
        font-size: 18px;
    }

    /* TABLE BORDER TEBAL (GARIS-GARIS) */
    table.table-bordered {
        border: 1px solid #2c3e50 !important;
    }
    table.table-bordered th,
    table.table-bordered td {
        border: 1px solid #2c3e50 !important;
        vertical-align: middle !important;
        text-align: center;
        font-size: 14px;
        background: #fff;
    }

    thead.table-dark th {
        background: #2c3e50 !important;
        color: white !important;
    }

    .card-custom {
    background: #ffffff !important;
    border: 1px solid #d0d4da !important;
    border-radius: 12px !important;
    padding: 25px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}
.card-custom-prediksi {
    background: #ffffff !important;
    border: 1px solid #d0d4da !important;
    border-radius: 12px !important;
    padding: 25px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    width: 400px;
}


    .mt-small { margin-top: 10px; }

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
        background-color: #ffffff; 
        margin: 2% auto;
        padding: 0;
        border-radius: 12px;
        width: 1100px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 30px rgba(0,0,0,0.35);
        opacity: 0;
        transform: scale(0.9);
        transition: transform 0.35s ease, opacity 0.35s ease;
        color: #3b4e71;
    }
    .modal.show .modal-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .modal-header {
        background-color: #3b4e71;
        color: #ffffff;
        padding: 15px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        font-size: 24px;
        font-weight: 600;
    }
    
    .modal-body {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid #3b4e71;
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
        background-color: #007bff;
        color: white;
        font-size: 16px;
    }
    .modal-footer .btn-save:hover {
        background-color: #0056b3;
    }
    
    /* INPUT inside modal (special width) */
    .modal-body .form-control {
        width: 500px;
        display: block;
        padding: 10px;
        font-size: 16px;
        margin-top: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #3b4e71;
        color: #3b4e71;
    }
    .modal-body .fw-bold {
        font-size: 18px;
    }
    
    /* MODAL TABLE STYLING */
    #detailModal table th {
        font-size: 15px !important;
        padding: 12px 10px !important;
    }
    #detailModal table td {
        font-size: 15px !important;
        padding: 12px 10px !important;
        vertical-align: middle;
    }    
       /* ===============================
       BUTTONS
    =============================== */
    /* PAGINATION MODERN STYLING */
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 10px;
        padding-left: 0;
        list-style: none;
    }
    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 14px;
        border-radius: 8px !important;
        border: 1px solid #e5e7eb;
        background-color: #ffffff;
        color: #4b5563;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        margin-left: 4px;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #304c89, #4361ee) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(67, 97, 238, 0.25) !important;
    }
    .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
        background-color: #f3f4f6;
        color: #304c89;
        border-color: #d1d5db;
        transform: translateY(-2px);
    }
    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: #f9fafb;
        cursor: not-allowed;
        border-color: #e5e7eb;
    }
    .musiman, .input-manual {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    .input-manual {
        background-color: #28a745;
    }
    .musiman:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    .input-manual:hover {
        background-color: #218838;
        transform: scale(1.05);
    }
    /* ============================
        WRAPPER 3 TABEL 1 BARIS
        ============================ */
            /* Wrapper kolom dalam 1 card */
        /* Lebarkan setiap tabel */
        .col-tabel table {
            width: 100% !important;      /* tabel memenuhi kolom */
            table-layout: fixed !important; /* kolom rata & tidak sempit */
        }

        /* Lebarkan kolom wrapper */
        .col-tabel {
            flex: 1;
            min-width: 400px;   /* tambah lebar tabel */
        }

        /* Biar jaraknya makin rapat */
        .row-tabel-3 {
            display: flex;
            gap: 15px !important; 
        }

        /* ==== PERLEBAR TABEL UTAMA ==== */
        #tabelGabunganBox table {
            width: 100% !important;         /* tabel full container */
            table-layout: fixed !important; /* kolom rata & tidak mepet */
        }

        /* Lebarkan kolom agar tidak sempit */
        #tabelGabunganBox th,
        #tabelGabunganBox td {
            padding: 10px !important;
            font-size: 15px;
            vertical-align: middle;
        }

        /* CARD UTAMA DIPERLEBAR */
        .card-custom {
            width: 96% !important;
            max-width: 100% !important;
            padding: 25px !important;
            margin: 0 auto;
        }

        /* Jika ingin tabel full screen lebar tampilan */
        #tabelGabunganBox {
            width: 100%;
            overflow-x: auto;               /* antisipasi jika terlalu panjang */
        }

    /* =======================================
    FORM PREDIKSI STYLE BARU
    ======================================= */

    .prediksi-wrapper{
        margin-top: 30px;
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .prediksi-header{
        background: linear-gradient(135deg, #304c89, #4361ee);
        color: white;
        padding: 26px 35px;
        font-size: 22px;
        font-weight: 700;
    }

    .prediksi-body{
        padding: 35px;
    }

    /* GRID FORM */
    .prediksi-grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        align-items: start;
    }

    /* GROUP */
    .prediksi-group{
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .group-kecil{
        margin-left: 15px;
    }
    .group-kecil .prediksi-input{
        width: 75%;
        height: 40px;
    }

    .group-besar{
        margin-left: -20px;
    }
    .group-besar .prediksi-input{
        font-size: 18px;
        width: 40%;
        height: 40px;
    }

    /* LABEL */
    .prediksi-group label{
        font-size: 15px;
        font-weight: 700;
        color: #4b5563;
        margin-bottom: 10px;
        min-height: 24px; /* bikin semua label sejajar */
    }

    /* INPUT */
    .prediksi-input{
        width: 100%;
        height: 40px;
        border-radius: 7px;
        border: 1px solid #d1d5db;
        padding: 0 18px;
        font-size: 16px;
        outline: none;
        transition: 0.3s;
        background: #fff;
    }

    .prediksi-input:focus{
        border-color: #4361ee;
        box-shadow: 0 0 0 4px rgba(67,97,238,0.12);
    }

    /* NOTE */
    .prediksi-note{
        margin-top: 10px;
        color: #9ca3af;
        font-size: 13px;
        line-height: 1.5;
    }


    /* MODE + BUTTON SEJAJAR */
   .button-wrap{
        grid-column: 4;
        justify-self: end;
        align-self: end;
        margin-left: 0 !important;
    }

    /* BUTTON */
    .prediksi-button-wrap{
        display: flex;
        align-items: end;
        margin-bottom: 2px;
    }

    .btn-prediksi{
        width: 170px;
        height: 45px;
        border: none;
        border-radius: 7px;
        background: linear-gradient(135deg, #304c89, #4361ee);
        color: white;
        font-size: 16px;
        font-weight: 700;
        transition: 0.3s;
    }

    .btn-prediksi:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(67,97,238,0.25);
    }

    /* RESPONSIVE */
    @media (max-width: 1200px){
        .prediksi-grid{
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px){
        .prediksi-grid{
            grid-template-columns: 1fr;
        }
    }

    /* DARK MODE */
    body.dark .prediksi-wrapper{
        background: #334155;
    }

    body.dark .prediksi-input{
        background: #475569;
        border: 1px solid #64748b;
        color: #f1f5f9;
    }

    body.dark .prediksi-group label{
        color: #f1f5f9;
    }

    body.dark .prediksi-note{
        color: #cbd5e1;
    }

    /* INPUT BULAN */
    .input-bulan{
        position: relative;
        width: 40%;
        margin-left: 100px;
    }

    .input-bulan .prediksi-input{
        width: 100%;
        padding-right: 15px;
    }

    .bulan-label{
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        font-weight: 600;
        color: #6b7280;
        pointer-events: none;
    }

        .event-note-wrapper{
            margin-top: 14px;
            padding-left: 2px;
        }

        .event-note{
            font-size: 13px;
            color: #9ca3af;
            font-weight: 500;
            line-height: 1.6;
        }
        /* ======================================
        ATUR LEBAR MASING-MASING KOLOM
        ====================================== */

        /* Kolom No */
        #tabelGabunganBox table th:nth-child(1),
        #tabelGabunganBox table td:nth-child(1){
            width: 40px !important;
            min-width: 50px;
            max-width: 50px;
        }

        /* Nama Produk (diperbesar) */
        #tabelGabunganBox table th:nth-child(2),
        #tabelGabunganBox table td:nth-child(2){
            width: 180px !important;
            min-width: 180px;
            text-align: left !important;
            padding-left: 15px !important;
            white-space: normal !important;
        }

        /* α */
        #tabelGabunganBox table th:nth-child(3),
        #tabelGabunganBox table td:nth-child(3){
            width: 60px !important;
        }

        /* β */
        #tabelGabunganBox table th:nth-child(4),
        #tabelGabunganBox table td:nth-child(4){
            width: 60px !important;
        }

        /* Periode */
        #tabelGabunganBox table th:nth-child(5),
        #tabelGabunganBox table td:nth-child(5){
            width: 75px !important;
        }

        /* MAD */
        #tabelGabunganBox table th:nth-child(6),
        #tabelGabunganBox table td:nth-child(6){
            width: 70px !important;
        }

        /* MASE */
        #tabelGabunganBox table th:nth-child(7),
        #tabelGabunganBox table td:nth-child(7){
            width: 70px !important;
        }

        /* MAPE */
        #tabelGabunganBox table th:nth-child(8),
        #tabelGabunganBox table td:nth-child(8){
            width: 180px !important;
        }

        /* Tanggal */
        #tabelGabunganBox table th:nth-child(9),
        #tabelGabunganBox table td:nth-child(9){
            width: 130px !important;
        }

        /* Aksi */
        #tabelGabunganBox table th:nth-child(10),
        #tabelGabunganBox table td:nth-child(10){
            width: 130px !important;
            white-space: nowrap;
        }

        .container.mt-4{
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* ======================================
        HEADER TABEL CUSTOM GRADIENT
        ====================================== */
        .custom-table-head th{
            background: linear-gradient(
                135deg,
                #304c89,
                #4361ee
            ) !important;

            color: #fff !important;
            border-color: #2c3e50 !important;
            text-align: center;
            vertical-align: middle;
            font-weight: 700;
        }

        .info-python{
            margin-top: 12px;
            margin-left: 2px;
            display: flex;
            align-items: center;
            gap: 6px;

            font-size: 13px;
            color: #9ca3af;
            font-weight: 500;
        }

        .info-python i{
            font-size: 13px;
        }
        
        /* TOMBOL AKSI CIRCLE */
        .btn-circle-aksi {
            width: 36px !important;
            height: 36px !important;
            padding: 0 !important;
            border-radius: 50% !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 16px !important;
            border: none !important;
            color: #fff !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .btn-circle-aksi:hover {
            transform: scale(1.1);
            color: #fff !important;
        }
        .btn-eye-aksi { background-color: #3b82f6 !important; }
        .btn-pdf-aksi { background-color: #10b981 !important; }
        .btn-del-aksi { background-color: #ef4444 !important; }
        .btn-del-aksi { background-color: #ef4444 !important; }

        /* SEARCH BOX STYLING FROM PENJUALAN */
        .search-box{
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input{
            width: 400px;
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
            border-color: #475569;
        }
</style>
<div class="container mt-4">
    <h2 class="mb-3" style="border-left: 5px solid #304c89; padding-left: 10px;"><i class="fas fa-history me-2"></i> History Prediksi Penjualan</h2>

    @if(session('success'))
    <div class="alert" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;border-radius:8px;padding:12px 18px;margin-bottom:16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="font-size:18px;"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left:auto;background:none;border:none;font-size:18px;cursor:pointer;color:#065f46;">&times;</button>
    </div>
    @endif

    <div class="card shadow card-custom">
        <!-- SEARCH BOX -->
        <div class="d-flex justify-content-end p-3 border-bottom">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari produk, periode, atau bulan..."
                    value="{{ request('search') }}"
                 >
            </div>
        </div>
        
        <div id="tabelGabunganBox" class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead class="custom-table-head">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>α</th>
                            <th>𝛽</th>
                            <th>Periode</th>
                            <th>MAD</th>
                            <th>MASE</th>
                            <th>MAPE (%)</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $it)
                            @php $peramalanArr = json_decode($it->peramalan, true); @endphp
                            <tr>
                                <td>{{ $index + $items->firstItem() }}</td>
                                <td>{{ $it->nama_produk }}</td>
                                <td>{{ $it->alpha }}</td>
                                <td>{{ $it->beta }}</td>
                                <td>{{ $it->periode_prediksi }} Bulan</td>
                                <td>{{ $it->mad }}</td>
                                <td>{{ $it->mase }}</td>
                                <td style="white-space: nowrap;">
                                    {{ number_format($it->mape, 1) }}%
                                    @if($it->mape < 10)
                                        <span class="badge" style="background-color: #10b981; color: white; border-radius: 12px; padding: 4px 10px; font-size: 12px; font-weight: 700; margin-left: 8px;">Sangat Baik</span>
                                    @elseif($it->mape <= 20)
                                        <span class="badge" style="background-color: #eab308; color: white; border-radius: 12px; padding: 4px 10px; font-size: 12px; font-weight: 700; margin-left: 8px;">Baik</span>
                                    @elseif($it->mape <= 50)
                                        <span class="badge" style="background-color: #f97316; color: white; border-radius: 12px; padding: 4px 10px; font-size: 12px; font-weight: 700; margin-left: 8px;">Wajar</span>
                                    @else
                                        <span class="badge" style="background-color: #ef4444; color: white; border-radius: 12px; padding: 4px 10px; font-size: 12px; font-weight: 700; margin-left: 8px;">Buruk</span>
                                    @endif
                                </td>
                                <td>{{ $it->tanggal }}</td>
                                <td>
                                    <!-- Detail -->
                                    <button class="btn btn-circle-aksi btn-eye-aksi me-1" onclick="openDetailModal({{ $it->id }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <!-- Export PDF -->
                                    <a href="{{ route('history.exportPdf', $it->id) }}" target="_blank" class="btn btn-circle-aksi btn-pdf-aksi me-1" title="Export PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <!-- Hapus -->
                                    <form action="{{ route('history.destroy', $it->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data prediksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-circle-aksi btn-del-aksi" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            @php
                                $sales = \App\Models\Penjualan::where('kode_produk', $it->kode_produk)->get();
                                $monthly = [];
                                foreach($sales as $s) {
                                    if(empty($s->bulan)) continue;
                                    $key = \Carbon\Carbon::parse($s->bulan)->format('Y-m');
                                    $monthly[$key] = ($monthly[$key] ?? 0) + (int)$s->jumlah;
                                }
                                ksort($monthly);
                                $hLabels = array_keys($monthly);
                                $hData = array_values($monthly);
                                
                                $fData = is_array($peramalanArr) ? $peramalanArr : [];
                                $fLabels = [];
                                if(!empty($hLabels)) {
                                    $lastLabel = end($hLabels);
                                    $lastMonth = \Carbon\Carbon::createFromFormat('Y-m', $lastLabel)->startOfMonth();
                                    for($i = 1; $i <= $it->periode_prediksi; $i++) {
                                        $fLabels[] = $lastMonth->copy()->addMonths($i)->format('Y-m');
                                    }
                                }
                                
                                // Kalkulasi Holt untuk historical data (fitted values)
                                $fittedRows = [];
                                if(count($hData) >= 2) {
                                    $l = (float)$hData[0];
                                    $b = (float)$hData[1] - (float)$hData[0];
                                    $alpha = (float)$it->alpha;
                                    $beta = (float)$it->beta;
                                    
                                    for ($t = 1; $t < count($hData); $t++) {
                                        $forecast = $l + $b;
                                        $error = abs($hData[$t] - $forecast);
                                        $ape = $hData[$t] != 0 ? ($error / $hData[$t]) * 100 : 0;
                                        $prev_l = $l;
                                        
                                        $l = $alpha * $hData[$t] + (1 - $alpha) * ($l + $b);
                                        $b = $beta * ($l - $prev_l) + (1 - $beta) * $b;
                                        
                                        $fittedRows[$t] = [
                                            'alpha' => round($l, 4),
                                            'beta' => round($b, 4),
                                            'forecast' => round($forecast, 2),
                                            'mape' => round($ape, 1)
                                        ];
                                    }
                                }
                            @endphp
                            
                            <script>
                                window.historyDataDetail = window.historyDataDetail || {};
                                window.historyDataDetail[{{ $it->id }}] = {
                                    nama_produk: "{{ $it->nama_produk }}",
                                    alpha: "{{ $it->alpha }}",
                                    beta: "{{ $it->beta }}",
                                    historyLabels: @json($hLabels),
                                    historyData: @json($hData),
                                    forecastLabels: @json($fLabels),
                                    forecastData: @json($fData),
                                    fittedRows: @json($fittedRows)
                                };
                            </script>
                        @empty
                            <tr><td colspan="10" class="text-center">Belum ada history prediksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            <div class="mt-4 d-flex justify-content-end">
                {{ $items->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PREDIKSI -->
<div class="modal" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            Detail Prediksi: <strong id="modalTitle" style="margin-left: 8px;"></strong>
        </div>
        <div class="modal-body">
            
            <!-- GRAFIK -->
            <h5 class="mb-3" style="color: #3b4e71; font-size: 20px; font-weight: bold; border-left: 5px solid #304c89; padding-left: 10px;"><i class="fas fa-chart-line me-2"></i>   Grafik Aktual dan Prediksi</h5>
            <div class="card shadow card-custom mb-4" style="padding: 15px !important;">
                <div style="height: 400px; width: 100%;">
                    <canvas id="historyDetailChart"></canvas>
                </div>
            </div>
            
            <!-- TABEL FORECAST -->
            <h5 class="mb-3" style="color: #3b4e71; font-size: 20px; font-weight: bold; border-left: 5px solid #304c89; padding-left: 10px;"><i class="fas fa-table me-2"></i>   Table Iterasi Lengkap</h5>
            <div class="card shadow card-custom mb-4" style="padding: 15px !important;">
                <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                    <table class="table table-bordered mb-0" style="width: 100%; min-width: 100%;">
                    <thead class="custom-table-head" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th>No</th>
                            <th>Bulan</th>
                            <th>Aktual</th>
                            <th>α</th>
                            <th>𝛽</th>
                            <th>Peramalan</th>
                            <th>MAPE (%)</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody">
                    </tbody>
                </table>
            </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn-close" style="padding: 8px 20px; cursor: pointer;" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // AUTO SEARCH LOGIC (Tanpa tekan Enter, dengan debounce)
    let searchTimeout = null;
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            searchTimeout = setTimeout(() => {
                const url = new URL(window.location.href);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                // Reset to page 1 when searching
                url.searchParams.delete('page');
                window.location.href = url.toString();
            }, 600); // Tunggu 600ms setelah user berhenti mengetik
        });
        
        // Letakkan kursor di akhir teks saat halaman dimuat (agar enak saat ngetik)
        if (searchInput.value) {
            const val = searchInput.value;
            searchInput.focus();
            searchInput.value = '';
            searchInput.value = val;
        }
    }

    let detailChart = null;

    function openDetailModal(id) {
        const data = window.historyDataDetail[id];
        if(!data) return;
        
        document.getElementById('modalTitle').innerText = data.nama_produk;
        
        // Populate Table
        let tbody = '';
        let no = 1;
        
        const alphaGlobal = data.alpha;
        const betaGlobal = data.beta;

        // Helper format bulan 
        const formatLabel = (lbl) => {
            const bulanMap = {
                "01":"Januari",
                "02":"Februari",
                "03":"Maret",
                "04":"April",
                "05":"Mei",
                "06":"Juni",
                "07":"Juli",
                "08":"Agustus",
                "09":"September",
                "10":"Oktober",
                "11":"November",
                "12":"Desember"
            };

            if (typeof lbl === "string" && lbl.includes("-")) {
                let parts = lbl.split('-');
                if(parts.length >= 2) {
                    const year = parts[0];
                    const month = parts[1];
                    return `${bulanMap[month] || month} ${year}`;
                }
            }
            return String(lbl || "");
        };

        // 1. Loop History Data
        data.historyLabels.forEach((lbl, i) => {
            let bulan = formatLabel(lbl);
            let aktual = data.historyData[i];
            
            let alphaCol = '-';
            let betaCol = '-';
            let peramalanCol = '-';
            let mapeCol = '-';
            
            if (i > 0 && data.fittedRows && data.fittedRows[i]) {
                let fit = data.fittedRows[i];
                alphaCol = fit.alpha;
                betaCol = fit.beta;
                peramalanCol = Number(fit.forecast).toFixed(2);
                mapeCol = Number(fit.mape).toFixed(1) + '%';
            }
            
            tbody += `<tr>
                <td class="text-center">${no++}</td>
                <td>${bulan}</td>
                <td class="text-center">${aktual}</td>
                <td class="text-center">${alphaCol}</td>
                <td class="text-center">${betaCol}</td>
                <td class="text-center">${peramalanCol}</td>
                <td class="text-center">${mapeCol}</td>
            </tr>`;
        });
        
        // 2. Loop Forecast Data
        data.forecastLabels.forEach((lbl, i) => {
            let bulan = formatLabel(lbl);
            let val = data.forecastData[i] || 0;
            
            tbody += `<tr>
                <td class="text-center">${no++}</td>
                <td>${bulan}</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-center">${Number(val).toFixed(2)}</td>
                <td class="text-center">-</td>
            </tr>`;
        });
        
        document.getElementById('modalTableBody').innerHTML = tbody;
        
        // Draw Chart
        if(detailChart) {
            detailChart.destroy();
        }
        
        const ctx = document.getElementById('historyDetailChart').getContext('2d');
        
        const hLabelsFormat = data.historyLabels.map(formatLabel);
        const fLabelsFormat = data.forecastLabels.map(formatLabel);
        
        const allLabels = [...hLabelsFormat, ...fLabelsFormat];
        const hSeries = [...data.historyData, ...Array(data.forecastData.length).fill(null)];
        const fSeries = [...Array(data.historyData.length).fill(null), ...data.forecastData];
        
        detailChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [
                    { 
                        label: 'Penjualan Aktual', 
                        data: hSeries,
                        borderWidth: 2 
                    },
                    { 
                        label: 'Prediksi DES (Holt)', 
                        data: fSeries,
                        borderWidth: 3, 
                        borderDash: [6,4] 
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 100
                        }
                    }
                }
            }
        });
        
        // Show Modal
        document.getElementById('detailModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.remove('show');
    }
</script>
@endsection
