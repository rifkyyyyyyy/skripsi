<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\Prediksi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = now()->year;

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        /*
        ==========================
        TOTAL PRODUK
        ==========================
        */
        $totalProduk = Produk::count();

       /*
        ==========================
        TOTAL DATA PERAMALAN DES
        Jumlah record pada tabel prediksi
        ==========================
        */
        $totalPeramalan = Prediksi::count();
        /*
        ==========================
        TOTAL PENJUALAN
        Bulan terpilih
        ==========================
        */
        $totalPenjualan = Penjualan::whereMonth(
                'bulan',
                $bulan
            )
            ->whereYear(
                'bulan',
                $tahun
            )
            ->sum('jumlah');

        $penjualanHariIni =
            $totalPenjualan;

        /*
        ==========================
        DATA PIE CHART
        SEMUA PRODUK (20)
        termasuk yang penjualannya 0
        ==========================
        */
        $penjualanPerProduk =
            Produk::leftJoin(
                'penjualans',
                function ($join) use (
                    $bulan,
                    $tahun
                ) {

                    $join->on(
                        'produks.nama_produk',
                        '=',
                        'penjualans.nama_produk'
                    )
                    ->whereMonth(
                        'penjualans.bulan',
                        $bulan
                    )
                    ->whereYear(
                        'penjualans.bulan',
                        $tahun
                    );
                }
            )
            ->selectRaw(
                '
                produks.nama_produk,
                COALESCE(
                    SUM(penjualans.jumlah),
                    0
                ) as total
                '
            )
            ->groupBy(
                'produks.nama_produk'
            )
            ->orderBy(
                'produks.id',
                'asc'
            )
            ->get();

        $labelPenjualan =
            $penjualanPerProduk
            ->pluck('nama_produk');

        $dataPenjualanPie =
            $penjualanPerProduk
            ->pluck('total');

        /*
        ==========================
        TOTAL SEMUA PENJUALAN
        ==========================
        */
        $totalSemuaPenjualan =
            Penjualan::sum(
                'jumlah'
            );

        /*
        ==========================
        TREND PENJUALAN BULANAN
        ==========================
        */
        $penjualanBulanan =
            Penjualan::whereYear(
                'bulan',
                $tahun
            )
            ->selectRaw(
                'MONTH(bulan)
                as bulan_ke,
                SUM(jumlah)
                as total'
            )
            ->groupBy(
                'bulan_ke'
            )
            ->pluck(
                'total',
                'bulan_ke'
            )
            ->toArray();

        $dataPenjualan = [];

        for (
            $i = 1;
            $i <= 12;
            $i++
        ) {
            $dataPenjualan[] =
                $penjualanBulanan[$i]
                ?? 0;
        }

        $labels = [
            "Januari $tahun",
            "Februari $tahun",
            "Maret $tahun",
            "April $tahun",
            "Mei $tahun",
            "Juni $tahun",
            "Juli $tahun",
            "Agustus $tahun",
            "September $tahun",
            "Oktober $tahun",
            "November $tahun",
            "Desember $tahun",
        ];

        return view('home', [

            'totalProduk' =>
                $totalProduk,

            'totalPenjualan' =>
                $totalPenjualan,

            'totalPeramalan' =>
                $totalPeramalan,

            'penjualanHariIni' =>
                $penjualanHariIni,

            'totalSemuaPenjualan' =>
                $totalSemuaPenjualan,

            'jumlahHari' =>
                12,

            'bulan' =>
                $bulan,

            'namaBulan' =>
                $namaBulan[$bulan],

            'tahun' =>
                $tahun,

            'dataPenjualan' =>
                $dataPenjualan,

            'labels' =>
                $labels,

            'labelPenjualan' =>
                $labelPenjualan,

            'dataPenjualanPie' =>
                $dataPenjualanPie
        ]);
    }
}