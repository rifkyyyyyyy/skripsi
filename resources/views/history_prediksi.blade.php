@extends('layout.sidebar')

@section('content')
<style>
    .history-container {
        margin-top: 20px;
        font-family: 'Outfit', sans-serif;
    }
    
    .page-section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .search-box {
        position: relative;
    }
    .search-box input {
        width: 320px;
        height: 42px;
        border-radius: 12px;
        border: 1px solid var(--glass-border);
        padding-left: 45px;
        padding-right: 15px;
        font-size: 14px;
        background: var(--glass-bg);
        transition: all 0.3s ease;
        font-weight: 500;
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
    }
    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }
    .search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    /* TOMBOL AKSI CIRCLE */
    .btn-circle-aksi {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        border-radius: 12px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 15px !important;
        border: none !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-circle-aksi:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        color: #fff !important;
    }
    .btn-eye-aksi { background: linear-gradient(135deg, #01B574, #019962) !important; }
    .btn-pdf-aksi { background: linear-gradient(135deg, #3b82f6, #2563eb) !important; }
    .btn-del-aksi { background: linear-gradient(135deg, #ef4444, #dc2626) !important; }

    /* PAGINATION MODERN STYLING */
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 20px;
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
        border-radius: 10px !important;
        border: 1px solid var(--glass-border);
        background-color: var(--glass-bg);
        color: var(--text-main);
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
        text-decoration: none;
        font-family: 'Outfit', sans-serif;
    }
    .pagination .page-item.active .page-link {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 10px rgba(67, 24, 255, 0.25) !important;
    }
    .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
        background-color: rgba(67, 24, 255, 0.05);
        color: var(--primary-color);
        transform: translateY(-2px);
    }
    .pagination .page-item.disabled .page-link {
        color: var(--text-muted);
        background-color: rgba(0, 0, 0, 0.02);
        cursor: not-allowed;
    }
    
    .badge-status {
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 8px;
        font-family: 'Outfit', sans-serif;
    }
    .badge-sangat-baik { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    .badge-baik { background-color: rgba(234, 179, 8, 0.1); color: #eab308; }
    .badge-wajar { background-color: rgba(249, 115, 22, 0.1); color: #f97316; }
    .badge-buruk { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }

    /* MODAL */
    .modal {
        visibility: hidden;
        opacity: 0;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
        z-index: 1050;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .modal.show {
        visibility: visible;
        opacity: 1;
    }
    .modal-content {
        background: var(--card-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        width: 100%;
        max-width: 1000px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        position: relative;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    .modal.show .modal-content {
        transform: scale(1);
    }
    .modal-header {
        padding: 24px;
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
    }
    .modal-body {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }
    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid var(--glass-border);
        display: flex;
        justify-content: flex-end;
    }
    
    @media (max-width: 768px) {
        .search-box {
            width: 100%;
        }
        .search-box input {
            width: 100%;
        }
        .modal-content {
            margin: 15px;
            max-height: calc(100vh - 30px);
        }
    }
</style>
<div class="history-container">
    <h2 class="page-section-title">
        <i class="fas fa-history text-primary"></i> History Prediksi Penjualan
    </h2>

    @if(session('success'))
    <div class="alert" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
        <i class="fas fa-check-circle" style="font-size: 18px;"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; font-size: 18px; cursor: pointer; color: #10b981;">&times;</button>
    </div>
    @endif

    <div class="card-custom">
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
        
        <div id="tabelGabunganBox" class="table-wrapper">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>α</th>
                            <th>𝛽</th>
                            <th>Periode</th>
                            <th>MAD</th>
                            <th>MSE</th>
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
                                <td>{{ $it->mse }}</td>
                                <td style="white-space: nowrap;">
                                    {{ number_format($it->mape, 1) }}%
                                    @if($it->mape < 10)
                                        <span class="badge-status badge-sangat-baik">Sangat Baik</span>
                                    @elseif($it->mape <= 20)
                                        <span class="badge-status badge-baik">Baik</span>
                                    @elseif($it->mape <= 50)
                                        <span class="badge-status badge-wajar">Wajar</span>
                                    @else
                                        <span class="badge-status badge-buruk">Buruk</span>
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
                        borderColor: '#4318FF',
                        backgroundColor: 'rgba(67, 24, 255, 0.15)',
                        fill: true,
                        borderWidth: 2,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#4318FF'
                    },
                    { 
                        label: 'Prediksi DES (Holt)', 
                        data: fSeries,
                        borderColor: '#01B574',
                        backgroundColor: 'rgba(1, 181, 116, 0.15)',
                        fill: true,
                        borderWidth: 3, 
                        borderDash: [6,4],
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#01B574'
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
