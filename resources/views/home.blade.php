@extends('layout.sidebar')
@section('content')
<style>
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 30px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-info h6 {
        color: var(--text-muted);
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .stat-info h2 {
        color: var(--text-main);
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }

    .stat-info p {
        color: var(--text-muted);
        font-size: 13px;
        margin: 0;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .icon-primary { background: rgba(67, 24, 255, 0.1); color: var(--primary-color); }
    .icon-success { background: rgba(1, 181, 116, 0.1); color: #01B574; }
    .icon-warning { background: rgba(255, 171, 0, 0.1); color: #FFAB00; }

    .dashboard-charts {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    .page-section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 15px;
        border-left: 4px solid var(--primary-color);
        padding-left: 10px;
    }

    .chart-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    /* Month Selector */
    .entries-select-wrapper {
        position: relative;
        display: inline-block;
    }
    .entries-select-wrapper .entries-chevron {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
        pointer-events: none;
    }
    .entries-select-wrapper select {
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
    .entries-select-wrapper select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 24, 255, 0.1);
    }

    @media (max-width: 992px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }
        .dashboard-charts {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid" style="padding-top: 20px;">

    <!-- Top Info Cards -->
    <div class="dashboard-stats">
        <div class="card-custom stat-card">
            <div class="stat-info">
                <h6>Jumlah Produk</h6>
                <h2>{{ number_format($totalProduk, 0, ',', '.') }}</h2>
                <p>Total Produk Tersedia</p>
            </div>
            <div class="stat-icon icon-primary">
                <i class="fas fa-box"></i>
            </div>
        </div>

        <div class="card-custom stat-card">
            <div class="stat-info">
                <h6>Jumlah Penjualan</h6>
                <h2>{{ number_format($totalPenjualan, 0, ',', '.') }}</h2>
                <p>Total Penjualan {{ $namaBulan }} {{ $tahun }}</p>
            </div>
            <div class="stat-icon icon-success">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>

        <div class="card-custom stat-card">
            <div class="stat-info">
                <h6>Data Peramalan DES</h6>
                <h2>{{ number_format($totalPeramalan, 0, ',', '.') }}</h2>
                <p>Total Double Exp. Smoothing</p>
            </div>
            <div class="stat-icon icon-warning">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
    </div>

    <!-- Charts Layout -->
    <div class="dashboard-charts">
        
        <!-- Trend Penjualan Bulanan -->
        <div>
            <h4 class="page-section-title">Trend Penjualan Bulanan</h4>
            <div class="card-custom">
                <div class="chart-header">
                    <div class="entries-select-wrapper">
                        <select id="pilihBulan">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <i class="fas fa-chevron-down entries-chevron"></i>
                    </div>
                </div>
                <div style="height: 650px; width: 100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Penjualan per Produk -->
        <div>
            <h4 class="page-section-title">Penjualan per Produk</h4>
            <div class="card-custom">
                <div style="height: 650px; width: 100%;">
                    <canvas id="chartPenjualan"></canvas>
                </div>
                <div style="text-align:center; color:var(--text-muted); font-size:14px; margin-top:20px; font-weight: 500;">
                    Distribusi Penjualan per Produk
                </div>
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
    backgroundColor: 'rgba(67, 97, 238, 0.15)',

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
            responsive: true,
            maintainAspectRatio: false,
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

                        hoverOffset: 10,
                        radius: '70%'
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
