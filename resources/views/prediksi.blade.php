@extends('layout.sidebar')

@php
    $produks = $produks ?? \App\Models\Produk::orderBy('nama_produk')->get();
@endphp

@section('content')

<style>
    .prediksi-wrapper {
        margin-top: 20px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        font-family: 'Outfit', sans-serif;
    }

    .prediksi-header {
        background: rgba(67, 24, 255, 0.1);
        color: var(--primary-color);
        padding: 24px 30px;
        font-size: 20px;
        font-weight: 700;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .prediksi-body {
        padding: 30px;
    }

    .prediksi-grid {
        display: grid;
        grid-template-columns: 400px 200px 1fr;
        gap: 20px;
        align-items: start;
        justify-content: start;
    }

    .prediksi-group {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .prediksi-group:last-child {
        align-items: flex-end;
    }

    .prediksi-group label {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 10px;
    }

    .prediksi-input {
        width: 100%;
        height: 48px;
        border-radius: 12px;
        border: 1px solid var(--glass-border);
        padding: 0 18px;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
        background: var(--glass-bg);
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
    }

    .prediksi-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }

    .input-bulan {
        position: relative;
    }
    .bulan-label {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        pointer-events: none;
    }

    .btn-prediksi {
        width: 250px;
        height: 48px;
        border: none;
        border-radius: 12px;
        background: var(--primary-color);
        color: white;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-prediksi:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(67, 24, 255, 0.3);
    }

    .info-python {
        margin-top: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .event-note {
        display: block;
        margin-top: 15px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .page-section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
        border-left: 4px solid var(--primary-color);
        padding-left: 10px;
    }

    .table-wrapper {
        overflow-x: auto;
    }
    
    .table th, .table td {
        white-space: nowrap;
    }

    /* CUSTOM SELECT PRODUK */
    .custom-select-wrapper {
        position: relative;
        width: 100%;
    }
    .custom-select-wrapper .select-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 16px;
        pointer-events: none;
        z-index: 2;
    }
    .custom-select-wrapper .select-chevron {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
        pointer-events: none;
        z-index: 2;
    }
    .prediksi-select-styled {
        width: 100%;
        height: 48px;
        border-radius: 12px;
        border: 1px solid var(--glass-border);
        background: var(--glass-bg);
        color: var(--text-main);
        font-size: 15px;
        font-weight: 500;
        padding: 0 44px 0 46px;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
        font-family: 'Outfit', sans-serif;
    }
    .prediksi-select-styled:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }

    @media (max-width: 900px) {
        .prediksi-grid {
            grid-template-columns: 1fr;
        }
        .prediksi-group:last-child {
            align-items: flex-start;
        }
        .btn-container {
            width: 100% !important;
        }
        .btn-prediksi {
            width: 100%;
        }
    }
</style>
<!-- ====================================================== -->
<!--                  FORM INPUT PREDIKSI                   -->
<!-- ====================================================== -->

<div class="prediksi-wrapper">

    <div class="prediksi-header">
        Input Prediksi Penjualan (Double Exponential Smoothing)
    </div>

    <div class="prediksi-body">

        <form id="formPrediksi">

            @csrf

            <div class="prediksi-grid">

                <!-- PRODUK -->
                <div class="prediksi-group">
                    <label>Pilih Produk</label>

                    <div class="custom-select-wrapper">
                        <i class="fas fa-box select-icon"></i>
                        <select name="kode_produk" class="prediksi-select-styled" required>
                            <option value="">-- Pilih Produk --</option>

                            @foreach($produks as $p)
                                <option value="{{ $p->kode_produk }}">
                                    {{ $p->nama_produk }} ({{ $p->kode_produk }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-chevron"></i>
                    </div>
                </div>

                <!-- PERIODE -->
                <div class="prediksi-group">
                    <label>Periode Prediksi (Bulan)</label>
                    <div class="input-bulan">
                        <input
                            type="number"
                            name="periode"
                            class="prediksi-input"
                            min="1"
                            max="36"
                            value="12"
                            required
                        >
                        <span class="bulan-label">Bulan</span>
                    </div> 
                </div>

                <!-- BUTTON -->
                <div class="prediksi-group">
                    <label>&nbsp;</label>
                    <div class="btn-container" style="width: 250px;">
                        <button type="submit" class="btn-prediksi" style="width: 100%;">
                            <i class="fas fa-chart-line"></i>
                            Prediksi
                        </button>
                        <div class="info-python" style="justify-content: flex-start;">
                            <i class="fab fa-python"></i> Python Statsmodels
                        </div>
                    </div>
                </div>
            </div>
            
            <small class="event-note">
                <i class="fas fa-info-circle"></i> Masukkan jumlah periode prediksi (1 - 12 Bulan)
            </small>
        </form>

    </div>

</div>

 <!-- ====================================================== -->
        <!--   1 CARD BESAR UNTUK 3 TABEL (SEJARIS DALAM 1 CARD)   -->
        <!-- ====================================================== -->

        <h4 class="page-section-title">Tabel Prediksi DES (Holt)</h4>

        <div class="card-custom">
            <div class="table-wrapper" id="tabelGabunganBox">
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
                            <th>Peramalan</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="tabelGabungan"></tbody>
                </table>
            </div>
        </div>
<div class="container mt-4">
    <!-- ====================================================== -->
    <!--                        GRAFIK                          -->
    <!-- ====================================================== -->
    <h4 class="page-section-title">Grafik Data Aktual & Prediksi</h4>

    <div class="card-custom">
        <div style="height: 400px; width: 100%;">
            <canvas id="chartPrediksi"></canvas>
        </div>
    </div>

</div>

<script>
    window.PREDIKSI_ROUTES = {
        predict: "{{ route('prediksi.predict') }}"
    };
    window.CSRF_TOKEN = "{{ csrf_token() }}";
</script>

@include('prediksi_js')
@endsection
