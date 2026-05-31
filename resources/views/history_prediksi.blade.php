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
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 600px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        opacity: 0;
        transform: scale(0.8);
        transition: transform 0.35s ease, opacity 0.35s ease;
        color:  #3b4e71;
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
       /* ===============================
       BUTTONS
    =============================== */
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
            width: 240px !important;
            min-width: 240px;
            text-align: left !important;
            padding-left: 15px !important;
            white-space: normal !important;
        }

        /* α */
        #tabelGabunganBox table th:nth-child(3),
        #tabelGabunganBox table td:nth-child(3){
            width: 85px !important;
        }

        /* β */
        #tabelGabunganBox table th:nth-child(4),
        #tabelGabunganBox table td:nth-child(4){
            width: 85px !important;
        }

        /* Periode */
        #tabelGabunganBox table th:nth-child(5),
        #tabelGabunganBox table td:nth-child(5){
            width: 160px !important;
        }

        /* MAD */
        #tabelGabunganBox table th:nth-child(6),
        #tabelGabunganBox table td:nth-child(6){
            width: 85px !important;
        }

        /* MASE */
        #tabelGabunganBox table th:nth-child(7),
        #tabelGabunganBox table td:nth-child(7){
            width: 85px !important;
        }

        /* MAPE */
        #tabelGabunganBox table th:nth-child(8),
        #tabelGabunganBox table td:nth-child(8){
            width: 90px !important;
        }

        /* Peramalan */
        #tabelGabunganBox table th:nth-child(9),
        #tabelGabunganBox table td:nth-child(9){
            width: 95px !important;
        }

        /* Tanggal */
        #tabelGabunganBox table th:nth-child(10),
        #tabelGabunganBox table td:nth-child(10){
            width: 130px !important;
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
</style>
<div class="container mt-4">
    <h2 class="mb-3">History Prediksi & Stok</h2>

    <div class="card shadow card-custom">
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
                            <th>MAPE</th>
                            <th>Peramalan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $it)
                            <tr>
                                <td>{{ $index + $items->firstItem() }}</td>
                                <td>{{ $it->nama_produk }}</td>
                                <td>{{ $it->alpha }}</td>
                                <td>{{ $it->beta }}</td>
                                <td>{{ $it->periode_prediksi }}</td>
                                <td>{{ $it->mad }}</td>
                                <td>{{ $it->mase }}</td>
                                <td>{{ $it->mape }}%</td>
                                <td>
                                    @php
                                        $peramalanArr = json_decode($it->peramalan, true);
                                        $totalPeramalan = is_array($peramalanArr) ? array_sum($peramalanArr) : 0;
                                    @endphp
                                    {{ number_format($totalPeramalan) }}
                                </td>
                                <td>{{ $it->tanggal }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info text-white" onclick="openDetailModal({{ $it->id }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                            @endphp
                            
                            <script>
                                window.historyDataDetail = window.historyDataDetail || {};
                                window.historyDataDetail[{{ $it->id }}] = {
                                    nama_produk: "{{ $it->nama_produk }}",
                                    historyLabels: @json($hLabels),
                                    historyData: @json($hData),
                                    forecastLabels: @json($fLabels),
                                    forecastData: @json($fData)
                                };
                            </script>
                        @empty
                            <tr><td colspan="11" class="text-center">Belum ada history prediksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PREDIKSI -->
<div class="modal" id="detailModal">
    <div class="modal-content" style="width: 800px; max-width: 95%;">
        <div class="modal-header">
            Detail Prediksi: <strong id="modalTitle" style="margin-left: 8px;"></strong>
        </div>
        <div class="modal-body">
            
            <!-- GRAFIK -->
            <div class="card shadow card-custom mb-4" style="padding: 15px !important;">
                <div style="height: 250px; width: 100%;">
                    <canvas id="historyDetailChart"></canvas>
                </div>
            </div>
            
            <!-- TABEL FORECAST -->
            <h5 class="mb-3" style="color: #3b4e71; font-weight: bold;">Table Forecast (Peramalan)</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="custom-table-head">
                        <tr>
                            <th>Bulan</th>
                            <th>Forecast</th>
                            <th>Rekomendasi (ceil)</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody">
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn-close" style="padding: 8px 20px; cursor: pointer;" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let detailChart = null;

    function openDetailModal(id) {
        const data = window.historyDataDetail[id];
        if(!data) return;
        
        document.getElementById('modalTitle').innerText = data.nama_produk;
        
        // Populate Table
        let tbody = '';
        data.forecastLabels.forEach((lbl, i) => {
            let val = data.forecastData[i] || 0;
            
            // Format Bulan
            let parts = lbl.split('-');
            let monthName = '';
            if(parts.length >= 2) {
                const b = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                monthName = b[parseInt(parts[1]) - 1] + ' ' + parts[0];
            } else {
                monthName = lbl;
            }
            
            tbody += `<tr>
                <td>${monthName}</td>
                <td>${Number(val).toFixed(2)}</td>
                <td>${Math.ceil(val)}</td>
            </tr>`;
        });
        document.getElementById('modalTableBody').innerHTML = tbody;
        
        // Draw Chart
        if(detailChart) {
            detailChart.destroy();
        }
        
        const ctx = document.getElementById('historyDetailChart').getContext('2d');
        
        // Helper format bulan grafik
        const formatLabel = (lbl) => {
            let parts = lbl.split('-');
            if(parts.length >= 2) {
                const b = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                return b[parseInt(parts[1]) - 1] + ' ' + parts[0];
            }
            return lbl;
        };
        
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
                        borderColor: '#60a5fa', 
                        backgroundColor: '#60a5fa',
                        borderWidth: 2 
                    },
                    { 
                        label: 'Prediksi', 
                        data: fSeries, 
                        borderColor: '#fb7185', 
                        backgroundColor: '#fb7185',
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
