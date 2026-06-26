<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrediksiController extends Controller
{
    public function index()
    {
        $produks = Produk::select(
                'kode_produk',
                'nama_produk'
            )
            ->groupBy(
                'kode_produk',
                'nama_produk'
            )
            ->orderBy('nama_produk')
            ->get();

        return view(
            'prediksi',
            compact('produks')
        );
    }

    public function predict(Request $request)
    {
        try {

            $request->validate([
                'kode_produk' => 'required',
                'periode' => 'required|integer|min:1|max:36',
            ]);

            $horizon = (int) $request->periode;

            /*
            ======================================
            AMBIL DATA PENJUALAN
            ======================================
            */
            $sales = Penjualan::whereRaw(
                'TRIM(kode_produk)=?',
                [trim($request->kode_produk)]
            )->get();

            if ($sales->isEmpty()) {
                return response()->json([
                    'error' =>
                    'Data penjualan tidak ditemukan.'
                ], 422);
            }

            /*
            ======================================
            AGREGASI BULAN
            ======================================
            */
            $monthly = [];

            foreach ($sales as $s) {

                if (empty($s->bulan)) {
                    continue;
                }

                try {

                    $key = Carbon::parse(
                        $s->bulan
                    )->format('Y-m');

                    $monthly[$key] =
                        ($monthly[$key] ?? 0)
                        + (int) $s->jumlah;

                } catch (\Exception $e) {
                    continue;
                }
            }

            ksort($monthly);

            $labels = array_keys($monthly);
            $valuesRaw = array_values($monthly);

            if (count($valuesRaw) < 3) {
                return response()->json([
                    'error' =>
                    'Minimal butuh 3 bulan data.'
                ], 422);
            }

            $values = $valuesRaw;

            /*
            ======================================
            OPTIMASI PARAMETER
            ======================================
            */
            $auto =
                $this->getOptimalHoltParams(
                    $values
                );

            $alpha = $auto['alpha'];
            $beta = $auto['beta'];

            /*
            ======================================
            FORECAST
            ======================================
            */
            $forecast =
                $this->holtForecast(
                    $values,
                    $alpha,
                    $beta,
                    $horizon
                );

            $lastLabel = end($labels);

            $lastMonth =
                Carbon::createFromFormat(
                    'Y-m',
                    $lastLabel
                )->startOfMonth();

            $forecastLabels = [];

            for (
                $i = 1;
                $i <= $horizon;
                $i++
            ) {

                $forecastLabels[] =
                    $lastMonth
                    ->copy()
                    ->addMonths($i)
                    ->format('Y-m');
            }

            /*
            ======================================
            AMBIL 9 BULAN HISTORI TERAKHIR
            ======================================
            */
            $historyLimit = 12 - $horizon;

            $historyLabels =
                array_slice(
                    $labels,
                    -$historyLimit
                );

            $historyValues =
                array_slice(
                    $values,
                    -$historyLimit
                );

            /*
            ======================================
            GABUNGKAN 12 PERIODE
            ======================================
            */
            $periodeLabels =
                array_merge(
                    $historyLabels,
                    $forecastLabels
                );

            $periodeValues =
                array_merge(
                    $historyValues,
                    array_map(
                        fn($x) => round($x),
                        $forecast
                    )
                );

            /*
            ======================================
            REKOMENDASI
            ======================================
            */
            $recommended =
                array_map(
                    fn($x) => ceil($x),
                    $forecast
                );

            $maxPred = max($forecast);

            $safetyStock =
                ceil($maxPred * 0.2);

            /*
            ======================================
            ERROR METRICS
            ======================================
            */
            $fittedRows =
            $this->holtFit(
                $values,
                $alpha,
                $beta
            );

        /*
        GLOBAL UNTUK DATABASE
        */
        $mad = round(
            collect($fittedRows)
            ->avg('mad'),
            3
        );

        $mape = round(
            collect($fittedRows)
            ->avg('mape'),
            1
        );

        $mse = round(
            collect($fittedRows)
            ->avg('mse'),
            3
        );

            /*
            ======================================
            NAMA PRODUK
            ======================================
            */
            $namaProduk =
                Produk::whereRaw(
                    'TRIM(kode_produk)=?',
                    [
                        trim(
                            $request
                            ->kode_produk
                        )
                    ]
                )->value(
                    'nama_produk'
                );

            /*
            ======================================
            SAVE PREDIKSI
            ======================================
            */
            Prediksi::updateOrCreate(
                [
                    'kode_produk' =>
                    trim(
                        $request
                        ->kode_produk
                    )
                ],
                [
                    'nama_produk' =>
                    $namaProduk,

                    'alpha' =>
                    $alpha,

                    'beta' =>
                    $beta,

                    'periode_prediksi' =>
                    $horizon,

                    'mad' =>
                    $mad,

                    'mse' =>
                    $mse,

                    'mape' =>
                    $mape,

                    'peramalan' =>
                    json_encode(
                        $forecast
                    ),

                    'tanggal' =>
                    $lastMonth
                    ->copy()
                    ->addMonth()
                    ->format(
                        'Y-m-d'
                    ),

                    'updated_at' =>
                    now()
                ]
            );

            /*
            ======================================
            RESPONSE JSON
            ======================================
            */
            return response()->json([

                'nama_produk' =>
                $namaProduk,

                'history' => [
                    'labels' =>
                    $labels,

                    'data' =>
                    $values
                ],

                'forecast' => [
                    'labels' =>
                    $forecastLabels,

                    'data' =>
                    $forecast
                ],

                /*
                INI YANG DIPAKAI
                UNTUK TABEL 12 KOLOM
                */
                'periode_table' => [
                    'labels' =>
                    $periodeLabels,

                    'data' =>
                    $periodeValues
                ],

                'errors' => [
                    'rows' =>
                    $fittedRows
                ],

                'auto' =>
                $auto,

                'recommendation' => [
                    'monthly' =>
                    $recommended,

                    'total' =>
                    array_sum(
                        $recommended
                    ),

                    'safety_stock' =>
                    $safetyStock
                ]
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' =>
                $e->getMessage(),

                'line' =>
                $e->getLine()
            ], 500);
        }
    }

    private function getOptimalHoltParams(
        $values
    ) {
        $pythonPath =
            "/usr/bin/python3";
            // "/home/dimn3613/virtualenv/public_html/rfkalfiansyah.my.id/skripsi/3.12/bin/python";

        $scriptPath =
            base_path(
                'holt_optimizer.py'
            );

        $command =
            escapeshellcmd(
                $pythonPath
            )
            . " "
            . escapeshellarg(
                $scriptPath
            )
            . " "
            . escapeshellarg(
                json_encode(
                    $values
                )
            )
            . " 2>&1";

        $output =
            shell_exec(
                $command
            );

        if (!$output) {
            throw new \Exception(
                "Python tidak mengembalikan output"
            );
        }

        $result =
            json_decode(
                $output,
                true
            );

        if (
            json_last_error()
            !== JSON_ERROR_NONE
        ) {
            throw new \Exception(
                "Output Python tidak valid: "
                . $output
            );
        }

        return $result;
    }

    private function holtFit(
        $y,
        $alpha,
        $beta
    ) {
        $l = $y[0];
        $b = $y[1] - $y[0];

        $rows = [];

        for ($t = 1; $t < count($y); $t++) {

            $forecast =
                $l + $b;

            $error =
                abs(
                    $y[$t]
                    - $forecast
                );

            $sq_error = pow(
                $error,
                2
            );

            $ape =
                $y[$t] != 0
                ? (
                    $error
                    / $y[$t]
                ) * 100
                : 0;

            $prev_l = $l;

            /*
            UPDATE HOLT
            */
            $l =
                $alpha
                * $y[$t]
                + (
                    1 - $alpha
                )
                * (
                    $l + $b
                );

            $b =
                $beta
                * (
                    $l - $prev_l
                )
                + (
                    1 - $beta
                )
                * $b;

            $rows[] = [
                'alpha' =>
                    round(
                        $l,
                        4
                    ),

                'beta' =>
                    round(
                        $b,
                        4
                    ),

                'forecast' =>
                    round(
                        $forecast,
                        2
                    ),

                'mad' =>
                    round(
                        $error,
                        2
                    ),

                'mse' =>
                    round(
                        $sq_error,
                        2
                    ),

                'mape' =>
                    round(
                        $ape,
                        1
                    )
            ];
        }



        return $rows;
    }

    private function holtForecast(
        $y,
        $alpha,
        $beta,
        $h
    ) {
        $l = $y[0];
        $b = $y[1] - $y[0];

        for (
            $t = 1;
            $t < count($y);
            $t++
        ) {

            $prev_l = $l;

            $l =
                $alpha * $y[$t]
                + (1 - $alpha)
                * ($l + $b);

            $b =
                $beta
                * ($l - $prev_l)
                + (1 - $beta)
                * $b;
        }

        $forecast = [];

        for (
            $i = 1;
            $i <= $h;
            $i++
        ) {

            $forecast[] =
                max(
                    0,
                    round(
                        $l
                        + $i * $b,
                        2
                    )
                );
        }

        return $forecast;
    }

    private function mape(
        $actual,
        $fitted
    ) {
        $sum = 0;

        for (
            $i = 1;
            $i < count($actual);
            $i++
        ) {

            if (
                $actual[$i] != 0
            ) {

                $sum += abs(
                    (
                        $actual[$i]
                        - $fitted[$i]
                    )
                    / $actual[$i]
                );
            }
        }

        return (
            $sum
            / (
                count($actual)
                - 1
            )
        ) * 100;
    }

    private function mad(
        $actual,
        $fitted
    ) {
        $sum = 0;

        for (
            $i = 1;
            $i < count($actual);
            $i++
        ) {

            $sum += abs(
                $actual[$i]
                - $fitted[$i]
            );
        }

        return
            $sum
            / (
                count($actual)
                - 1
            );
    }

    private function mse(
        $actual,
        $fitted
    ) {
        $sum = 0;

        for (
            $i = 1;
            $i < count($actual);
            $i++
        ) {

            $sum += pow(
                $actual[$i]
                - $fitted[$i],
                2
            );
        }

        return
            $sum
            / (
                count($actual)
                - 1
            );
    }
}