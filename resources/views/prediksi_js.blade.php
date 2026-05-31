<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chartPrediksi = null;

const ROUTES = window.PREDIKSI_ROUTES || {
    predict: "/prediksi/predict"
};

const CSRF_TOKEN = window.CSRF_TOKEN || "";

/* ===============================
   FORMAT BULAN
=============================== */
function convertToMonthYear(label) {
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

    if (typeof label === "string" && label.includes("-")) {
        const parts = label.split("-");

        if(parts.length >= 2){
            const year = parts[0];
            const month = parts[1];

            return `${bulanMap[month] || month} ${year}`;
        }
    }

    return String(label || "");
}

/* ===============================
   DEFAULT TABLE
=============================== */
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("tabelGabungan").innerHTML = `
        <tr>
            <td colspan="10" class="text-center text-muted">
                Belum ada hasil prediksi
            </td>
        </tr>
    `;
});

/* ===============================
   UPDATE TABLE HASIL PREDIKSI
=============================== */
function updatePredictionTable(data) {

    const tbody =
        document.getElementById(
            "tabelGabungan"
        );

    /*
    ====================================
    AMBIL DATA
    ====================================
    */
    const allHistoryLabels =
        data.history.labels || [];

    const allHistoryData =
        data.history.data || [];

    const forecastLabels =
        data.forecast.labels || [];

    const forecastData =
        data.forecast.data || [];

    const metricRows =
        data.errors.rows || [];

    /*
    ====================================
    TOTAL HARUS 12 PERIODE
    ====================================
    */
    const forecastCount =
        forecastLabels.length;

    const historyLimit =
        Math.max(
            0,
            12 - forecastCount
        );

    /*
    HISTORY TERAKHIR
    */
    const historyLabels =
        allHistoryLabels.slice(
            -historyLimit
        );

    const historyData =
        allHistoryData.slice(
            -historyLimit
        );

    /*
    METRIC HISTORY YANG SESUAI
    */
    const historyMetrics =
        metricRows.slice(
            -historyLimit
        );

    /*
    ====================================
    ALPHA BETA GLOBAL
    ====================================
    */
    const alpha =
        Number(
            data.auto.alpha
        ).toFixed(4);

    const beta =
        Number(
            data.auto.beta
        ).toFixed(4);

    /*
    ====================================
    ERROR TERAKHIR
    UNTUK FORECAST
    ====================================
    */
    const lastMetric =
        metricRows.length > 0
        ? metricRows[
            metricRows.length - 1
        ]
        : null;

    /*
    ====================================
    FORMAT TANGGAL
    ====================================
    */
    const now = new Date();

    const tanggal =
        String(now.getDate())
        .padStart(2, '0')
        + ' '
        + convertMonth(
            now.getMonth() + 1
        )
        + ' '
        + now.getFullYear();

    function convertMonth(month) {

        const bulan = {
            1:"Januari",
            2:"Februari",
            3:"Maret",
            4:"April",
            5:"Mei",
            6:"Juni",
            7:"Juli",
            8:"Agustus",
            9:"September",
            10:"Oktober",
            11:"November",
            12:"Desember"
        };

        return bulan[month];
    }

    let html = "";
    let no = 1;

    /*
    ====================================
    DATA HISTORY
    ====================================
    */
    historyLabels.forEach(
        (label, index) => {

        const metric =
            historyMetrics[index];

        html += `
            <tr>
                <td>${no++}</td>

                <td>
                    ${data.nama_produk}
                </td>

                <td>
                    ${
                        metric
                        ? metric.alpha
                        : alpha
                    }
                </td>

                <td>
                    ${
                        metric
                        ? metric.beta
                        : beta
                    }
                </td>

                <td>
                    ${convertToMonthYear(label)}
                </td>

                <td>
                    ${
                        metric
                        ? metric.mad
                        : 0
                    }
                </td>

                <td>
                    ${
                        metric
                        ? metric.mase
                        : 0
                    }
                </td>

                <td>
                    ${
                        metric
                        ? metric.mape + "%"
                        : "0%"
                    }
                </td>

                <td>
                    ${Math.round(
                        historyData[index]
                    )}
                </td>

                <td>
                    ${tanggal}
                </td>
            </tr>
        `;
    });

    /*
    ====================================
    DATA FORECAST
    ====================================
    */
    forecastLabels.forEach(
        (label, index) => {

        html += `
            <tr>
                <td>${no++}</td>

                <td>
                    ${data.nama_produk}
                </td>

                <td>
                    ${alpha}
                </td>

                <td>
                    ${beta}
                </td>

                <td>
                    ${convertToMonthYear(label)}
                </td>

                <td>
                    ${
                        lastMetric
                        ? lastMetric.mad
                        : 0
                    }
                </td>

                <td>
                    ${
                        lastMetric
                        ? lastMetric.mase
                        : 0
                    }
                </td>

                <td>
                    ${
                        lastMetric
                        ? lastMetric.mape + "%"
                        : "0%"
                    }
                </td>

                <td>
                    ${Math.round(
                        forecastData[index]
                    )}
                </td>

                <td>
                    ${tanggal}
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

/* ===============================
   SUBMIT PREDIKSI
=============================== */
document.getElementById('formPrediksi').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

   fetch(ROUTES.predict,{
        method:"POST",
        headers:{
            "X-CSRF-TOKEN":CSRF_TOKEN
        },
        body:formData
    })
    .then(async res => {

        const text = await res.text();

        let data;

        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error("Response bukan JSON:", text);

            throw {
                error: "Laravel mengembalikan response bukan JSON",
                raw: text
            };
        }

        if (!res.ok) {
            throw data;
        }

        return data;
    })
    .then(data => {

        if(data.error){
            alert(data.error);
            return;
        }

        /* TABEL */
        updatePredictionTable(data);

        /* GRAFIK */
        const historyLabels = data.history.labels || [];
        const historyData = data.history.data || [];
        const forecastLabels = data.forecast.labels || [];
        const forecastData = data.forecast.data || [];

        if(chartPrediksi) chartPrediksi.destroy();

        const ctx = document.getElementById('chartPrediksi').getContext('2d');

        chartPrediksi = new Chart(ctx,{
            type:'line',
            data:{
                labels:[
                    ...historyLabels.map(convertToMonthYear),
                    ...forecastLabels.map(convertToMonthYear)
                ],
                datasets:[
                    {
                        label:"Penjualan Aktual",
                        data:[
                            ...historyData,
                            ...Array(forecastData.length).fill(null)
                        ],
                        borderWidth:2
                    },
                    {
                        label:"Prediksi DES (Holt)",
                        data:[
                            ...Array(historyData.length).fill(null),
                            ...forecastData
                        ],
                        borderWidth:3,
                        borderDash:[6,4]
                    }
                ]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false,
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

        alert("Prediksi berhasil disimpan ke database!");
    })
    .catch(err => {
        console.error("ERROR ASLI:", err);

        alert(
            err.error ||
            err.message ||
            JSON.stringify(err)
        );
    });
});
</script>