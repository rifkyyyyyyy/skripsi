@extends('layout.sidebar')
@section('content')
<style>
:root {
    --card-bg: #ffffff;
    --card-text: #3b4e71;
    --chart-bg: #ffffff;
    --chart-grid: #d1d5db;
    --chart-text: #1e293b;
    --icon-color: #374151;
}

body.dark {
    --card-bg: #334155;
    --card-text: #e2e8f0;
    --chart-bg: #334155;
    --chart-grid: #ffffff;
    --chart-text: #f8fafc;
    --icon-color: #ffffff;
}

.dashboard-card,
.chart-box {
    background-color: var(--card-bg) !important;
    color: var(--card-text) !important;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transition: background 0.3s ease, color 0.3s ease;
}
.entries-control select{
    width: 200px;
    height: 50px;

    border: 2px solid #e5e7eb;
    border-radius: 18px;

    background: linear-gradient(135deg, #304c89, #4361ee);
    color: #ffffff;

    font-size: 18px;
    font-weight: 600;

   padding-left: 50px;

    cursor: pointer;

    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;

    transition: .3s;
    margin-top: -10px;
}

.entries-control{
    position: relative;
}

.entries-control::after{
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;

    position: absolute;
    right: 20px;
    top: 40%;

    transform: translateY(-50%);

    color: #ffffff;
    pointer-events: none;
}

.entries-control select:hover{
    border-color: #d1d5db;
}

.entries-control select:focus{
    outline: none;
    border-color: #4361ee;
    box-shadow: 0 0 0 4px rgba(67,97,238,.12);
}

.month-icon{
    position: absolute;
    left: 18px;
    top: 40%;

    transform: translateY(-50%);

    color: #ffffff;
    z-index: 2;
}


/* ==========================
   CARD JUMLAH PRODUK MODERN
========================== */
.product-card{
    position: relative;
    flex: 0 0 380px;
    height: 100px;
    overflow: hidden;
    border-radius: 28px;

    background: linear-gradient(135deg, #304c89, #4361ee);
    box-shadow: 0 12px 30px rgba(67, 97, 238, 0.35);

    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px;
}

/* text kiri */
.product-content{
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.product-content h6{
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-bottom: 100px;
}

.product-content h2{
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    line-height: 1;
    margin: 0;

    /* naikkan angka lebih ke tengah atas */
    position: relative;
    top: -80px;
}

.product-content p{
    color: rgba(255,255,255,0.85);
    font-size: 12px;
    margin-top: -60px;
}

/* icon kanan */
.product-icon-box{
    position: absolute;
    right: 35px;
    top: 35px;

    width: 50px;
    height: 50px;
    border-radius: 10px;

    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(6px);

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 2;
}

.product-icon-box i{
    color: white;
    font-size: 25px;
}

/* dekorasi bulat */
.circle{
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
}

.circle-1{
    width: 140px;
    height: 140px;
    top: -45px;
    right: 60px;
}

.circle-2{
    width: 230px;
    height: 230px;
    bottom: -90px;
    right: -50px;
}

/* ==========================
   CARD JUMLAH PERAMALAN MODERN
========================== */
.peramalan-card{
    position: relative;
    flex: 0 0 380px;
    height: 100px;
    overflow: hidden;
    border-radius: 28px;

    background: linear-gradient(135deg, #896730, #fda400);
    box-shadow: 0 12px 30px rgba(238, 192, 67, 0.35);

    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px;
}

/* text kiri */
.peramalan-content{
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.peramalan-content h6{
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-bottom: 100px;
}

.peramalan-content h2{
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    line-height: 1;
    margin: 0;

    /* naikkan angka lebih ke tengah atas */
    position: relative;
    top: -80px;
}

.peramalan-content p{
    color: rgba(255,255,255,0.85);
    font-size: 12px;
    margin-top: -60px;
}

/* icon kanan */
.peramalan-icon-box{
    position: absolute;
    right: 35px;
    top: 35px;

    width: 50px;
    height: 50px;
    border-radius: 10px;

    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(6px);

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 2;
}

.peramalan-icon-box i{
    color: white;
    font-size: 25px;
}

/* dekorasi bulat */
.circle{
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
}

.circle-1{
    width: 140px;
    height: 140px;
    top: -45px;
    right: 60px;
}

.circle-2{
    width: 230px;
    height: 230px;
    bottom: -90px;
    right: -50px;
}

/* ==========================
   CARD JUMLAH PENJUALAN MODERN
========================== */
.penjualan-card{
    position: relative;
    flex: 0 0 380px;
    height: 100px;
    overflow: hidden;
    border-radius: 28px;

    background: linear-gradient(135deg, #00733f, #00dd51);
    box-shadow: 0 12px 30px rgba(84, 238, 67, 0.35);

    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px;
}

/* text kiri */
.penjualan-content{
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.penjualan-content h6{
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 2px;
    margin-bottom: 100px;
}

.penjualan-content h2{
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    line-height: 1;
    margin: 0;

    /* naikkan angka lebih ke tengah atas */
    position: relative;
    top: -80px;
}

.penjualan-content p{
    color: rgba(255,255,255,0.85);
    font-size: 12px;
    margin-top: -60px;
}

/* icon kanan */
.penjualan-icon-box{
    position: absolute;
    right: 35px;
    top: 35px;

    width: 50px;
    height: 50px;
    border-radius: 10px;

    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(6px);

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 2;
}

.penjualan-icon-box i{
    color: white;
    font-size: 25px;
}

/* dekorasi bulat */
.circle{
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
}

.circle-1{
    width: 140px;
    height: 140px;
    top: -45px;
    right: 60px;
}

.circle-2{
    width: 230px;
    height: 230px;
    bottom: -90px;
    right: -50px;
}

/* ==========================
   WRAPPER CHART
========================== */
.trend-card{
    flex: 2;
    padding: 25px;
    height: 680px;
    border-radius: 26px;
}

.penjualan-produk-card{
    flex: 1;
    padding: 0;
    height: auto;
    min-height: 400px; /* tambahkan tinggi */
    border-radius: 26px;
}

/* HEADER */
.chart-header{
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

/* TITLE PRODUK STYLE */
.custom-title-produk{
    display:flex;
    align-items:center;
    gap:12px;
    padding:24px 28px;
    border-bottom:1px solid rgba(0,0,0,0.08);
}

body.dark .custom-title-produk{
    border-bottom:1px solid rgba(255,255,255,0.1);
}

.blue-line-produk{
    width:6px;
    height:28px;
    background:linear-gradient(135deg, #304c89, #4361ee);
}

.custom-title-produk h4{
    margin:0;
    font-size:18px;
    font-weight:700;
}

/* TITLE PENJUALAN STYLE */
.custom-title-penjualan{
    position: relative;
    display:flex;
    align-items:center;
    gap:12px;
    padding:24px 28px;
}

.custom-title-penjualan::after{
    content:'';
    position:absolute;

    left:0;
    right:0;

    bottom:55px; /* naikkan garis */
    
    height:1px;
    background:rgba(0,0,0,0.08);
}

body.dark .custom-title-penjualan::after{
    background:rgba(255,255,255,0.1);
}

.blue-line-penjualan{
    width:6px;
    height:28px;
    background:linear-gradient(135deg, #304c89, #4361ee);
    margin-top: -140px;
    margin-left:-20px;
}

.custom-title-penjualan h4{
    margin:0;
    font-size:18px;
    font-weight:700;
    margin-top: -140px;
}

/* PIE CHART */
.chart-wrapper{
    width:100%;
    height:550px;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
    margin-left: -25px;
}

#chartPenjualan{
    width:100% !important;
    height:100% !important;
}

/* SUBTITLE */
.chart-subtitle{
    text-align:center;
    color:#9ca3af;
    font-size:14px;
    margin-top:15px;
    padding-bottom:20px;
}

/* LINE CHART */
#salesChart{
    width:100% !important;
    height:550px !important;
}
</style>

<div class="container-fluid" style="padding-top: 50px;">

    <!-- Kartu Info -->
    <div style="display: flex; gap: 30px; justify-content: center; flex-wrap: nowrap;">
                <!-- Kartu Produk -->
                <div class="product-card shadow">
                    
                    <!-- dekorasi bulat background -->
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>

                    <!-- isi kiri -->
                    <div class="product-content">
                        <h6>JUMLAH PRODUK</h6>

                        <h2>{{ number_format($totalProduk, 0, ',', '.') }}</h2>

                        <p>Total Produk Tersedia</p>
                    </div>

                    <!-- icon kanan -->
                    <div class="product-icon-box">
                        <i class="fas fa-box"></i>
                    </div>

                </div>

                <!-- Kartu Penjualan -->
                <div class="penjualan-card shadow">
                    
                    <!-- dekorasi bulat background -->
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>

                    <!-- isi kanan -->
                    <div class="penjualan-content">
                        <h6>JUMLAH PENJUALAN</h6>

                        <h2>{{ number_format($totalPenjualan, 0, ',', '.') }}</h2>

                        <p>Total Penjualan {{ $namaBulan }} {{ $tahun }}</p>
                    </div>

                    <!-- icon kanan -->
                    <div class="penjualan-icon-box">
                        <i class="fas fa-shopping-cart"></i>
                    </div>

                </div>

                <!-- Kartu Peramalan -->
                <div class="peramalan-card shadow">
                    
                    <!-- dekorasi bulat background -->
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>

                    <!-- isi kanan -->
                    <div class="peramalan-content">
                        <h6>DATA PERAMALAN DES</h6>

                        <h2>{{ number_format($totalPeramalan, 0, ',', '.') }}</h2>

                        <p>Total Double Exp. Smoothing</p>
                    </div>

                    <!-- icon kanan -->
                    <div class="peramalan-icon-box">
                        <i class="fas fa-chart-bar"></i>
                    </div>

                </div>

            </div>


             <!-- WRAPPER GRAFIK + PENJUALAN PRODUK -->
            <div style="
                display:flex;
                gap:30px;
                align-items:stretch;
                margin-top:80px;
            ">

                <!-- Grafik Trend -->
                <div class="chart-box trend-card">

                    <div class="chart-header">
                        <div class="entries-control">
                            <i class="fas fa-calendar-alt month-icon"></i>

                            <select id="pilihBulan">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="custom-title-penjualan">
                        <span class="blue-line-penjualan"></span>
                        <h4>Trend Penjualan Bulanan</h4>
                    </div>

                    <canvas id="salesChart"></canvas>

                </div>

                <!-- Penjualan per Produk -->
                <div class="chart-box penjualan-produk-card">

                    <div class="custom-title-produk">
                        <span class="blue-line-produk"></span>
                        <h4>Penjualan per Produk</h4>
                    </div>

                    <div class="chart-wrapper">
                        <canvas id="chartPenjualan"></canvas>
                    </div>

                    <div class="chart-subtitle">
                        Distribusi Penjualan per Produk
                    </div>

                </div>

            </div>
</div>


<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ===================================================================
    LINE CHART (Trend Penjualan)
=================================================================== */
let labels = @json($labels);

let datasets = [{
    label: 'Penjualan',
    data: @json($dataPenjualan),

    // biru pudar
    backgroundColor: 'rgba(67, 97, 238, 0.08)',

    // garis utama
    borderColor: '#4361ee',

    borderWidth: 2,
    pointRadius: 4,
    pointBackgroundColor: '#4361ee',
    pointBorderColor: '#ffffff',
    pointBorderWidth: 2,

    tension: 0.35,
    fill: true
}];

const ctx = document.getElementById('salesChart').getContext('2d');

function createChart(isDarkMode) {
    return new Chart(ctx, {
        type: 'line',
        data: { labels: labels, datasets: datasets },
        options: {
            responsive: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: isDarkMode ? '#ffffff' : '#1e293b'
                    },
                    grid: {
                        color: isDarkMode ? '#ffffff33' : '#d1d5db',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    border: {
                        display: false,
                        dash: [8, 5]
                    }
                },
                x: {
                    ticks: {
                        color: isDarkMode ? '#ffffff' : '#1e293b',
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: ${context.raw}`
                    }
                },
                legend: {
                    display: false
                }
            }
        }
    });
}

let darkMode = document.body.classList.contains('dark');
let salesChart = createChart(darkMode);

new MutationObserver(() => {
    const newDark = document.body.classList.contains('dark');
    if (newDark !== darkMode) {
        darkMode = newDark;
        salesChart.destroy();
        salesChart = createChart(darkMode);
    }
}).observe(document.body, { attributes: true, attributeFilter: ['class'] });

document.getElementById('pilihBulan').addEventListener('change', () => {
    location.href = `{{ url('/dashboard') }}?bulan=${pilihBulan.value}`;
});
</script>


<script>
/* ===================================================================
    PIE CHART PRODUK & PENJUALAN + DARK MODE AWARE
=================================================================== */

let chartPenjualanInstance = null;

const percentLabelPlugin = {
    id: "percentLabel",
    afterDraw(chart) {
        const ctx = chart.ctx;
        const dataset = chart.data.datasets[0];
        const total = dataset.data.reduce((a, b) => a + b, 0);

        const isDark = document.body.classList.contains("dark");
        const textColor = isDark ? "#ffffff" : "#000000";

        chart.getDatasetMeta(0).data.forEach((slice, i) => {
            const value = dataset.data[i];
            const percent = ((value / total) * 100).toFixed(1) + "%";
            const { x, y } = slice.tooltipPosition();

            ctx.save();
            ctx.fillStyle = textColor;
            ctx.font = "bold 12px Arial";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(percent, x, y);
            ctx.restore();
        });
    }
};

function generateColors(total) {
    const colors = [];

    for (let i = 0; i < total; i++) {
        const hue = (i * 360 / total) % 360;
        colors.push(`hsl(${hue}, 70%, 55%)`);
    }

    return colors;
}

let dataProduk = [100];
let labelProduk = ['Produk'];

let dataPenjualan = @json($dataPenjualanPie);
let labelPenjualan = @json($labelPenjualan);

if (dataPenjualan.length === 0) {
    dataPenjualan = [100];
    labelPenjualan = ["Total Penjualan"];
}

/* ================= PENJUALAN ================= */
function renderChartPenjualan() {

    if (chartPenjualanInstance) {
        chartPenjualanInstance.destroy();
    }

    const isDark =
        document.body.classList.contains('dark');

    chartPenjualanInstance =
        new Chart(
            document.getElementById("chartPenjualan"),
            {
                type: "doughnut",

                data: {
                    labels: labelPenjualan,

                    datasets: [{
                        data: dataPenjualan,

                        backgroundColor:
                            generateColors(
                                dataPenjualan.length
                            ),

                        borderWidth: 4,
                        borderColor:
                            isDark
                                ? "#334155"
                                : "#ffffff",

                        hoverOffset: 10
                    }]
                },

                options: {

                    responsive: true,
                    maintainAspectRatio: false,

                    cutout: "72%",

                    layout: {
                        padding: 10
                    },

                    plugins: {

                        /* TOOLTIP */
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return (
                                        context.label +
                                        ' : ' +
                                        context.raw
                                    );
                                }
                            }
                        },

                        /* LEGEND / KETERANGAN PRODUK */
                        legend: {
                            display: true,
                            position: 'bottom',

                            maxHeight: 300,

                            labels: {
                                color: isDark ? '#ffffff' : '#374151',
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 10,
                                boxHeight: 10,
                                padding: 18,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        }
                    }
                },

                plugins: [

                    /* ICON TENGAH */
                    {
                        id:
                            "iconCenterPenjualan",

                        afterDraw(chart) {

                            const {
                                ctx,
                                chartArea:
                                {
                                    left,
                                    right,
                                    top,
                                    bottom
                                }
                            } = chart;

                            const x =
                                (left + right) / 2;

                            const y =
                                (top + bottom) / 2;

                            const iconColor =
                                getComputedStyle(
                                    document.body
                                )
                                .getPropertyValue(
                                    "--icon-color"
                                )
                                .trim();

                            ctx.save();

                            ctx.fillStyle =
                                iconColor;

                            ctx.font =
                                "900 42px 'Font Awesome 5 Free'";

                            ctx.textAlign =
                                "center";

                            ctx.textBaseline =
                                "middle";

                            ctx.fillText(
                                "\uf07a",
                                x,
                                y
                            );

                            ctx.restore();
                        }
                    }
                ]
            }
        );
}
/* ================= INIT ================= */
window.addEventListener("load", () => {
    renderChartPenjualan();
});

/* ================= DARK MODE LISTENER ================= */
new MutationObserver(() => {
    renderChartPenjualan();
}).observe(document.body, {
    attributes: true,
    attributeFilter: ['class']
});
</script>


@endsection
