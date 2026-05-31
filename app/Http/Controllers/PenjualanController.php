<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PenjualanController extends Controller
{
    // ✅ Menampilkan halaman daftar penjualan
   public function index(Request $request)
{
    $filter = $request->get('filter', '20_terbaru');
    $search = $request->get('search');
    $totalPenjualan = Penjualan::count();

    $penjualans = Penjualan::when($search, function ($q) use ($search) {
            $q->where('kode_produk', 'like', "%$search%")
              ->orWhere('nama_produk', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('bulan', 'like', "%$search%");
        })
        ->when($filter === '7_hari', function ($q) {
            $q->where('created_at', '>=', now()->subDays(7));
        })
        ->when($filter === '1_bulan', function ($q) {
            $q->where('created_at', '>=', now()->subMonth());
        })
        ->when($filter === 'all', function ($q) {
            return;
        })
        ->orderBy('created_at', 'desc')
        ->take($filter === '20_terbaru' ? 20 : null)
        ->get();

    // ambil semua produk
    $produks = Produk::select('kode_produk', 'nama_produk')->get();

    return view('dataPenjualan', compact(
        'penjualans',
        'filter',
        'search',
        'totalPenjualan',
        'produks'
    ));
}
    

   public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|max:50',
            'nama_produk' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'bulan' => 'required'
        ]);

        $validated['bulan'] = $validated['bulan'] . '-01';

        Penjualan::create($validated);

        return redirect()->back()->with('success', 'Penjualan berhasil ditambahkan!');
    }

   public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xls,xlsx'
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        $count = 0;

        $bulanMap = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12',
        ];

        if ($ext === 'csv' || $ext === 'txt') {

            $handle = fopen($file->getRealPath(), 'r');

            // skip header
            fgetcsv($handle, 1000, ';');

            while (($row = fgetcsv($handle, 1000, ';')) !== false) {

                if (count($row) < 5) continue;

                $bulanText = strtolower(trim($row[4])); // contoh: januari 2024
                [$namaBulan, $tahun] = explode(' ', $bulanText);

                $bulan = $bulanMap[$namaBulan] ?? '01';

                Penjualan::create([
                    'kode_produk' => trim($row[1]),
                    'nama_produk' => trim($row[2]),
                    'jumlah' => (int) trim($row[3]),
                    'bulan' => $tahun . '-' . $bulan . '-01',
                ]);

                $count++;
            }

            fclose($handle);

        } else {

            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            for ($i = 1; $i < count($sheetData); $i++) {

                if (count($sheetData[$i]) < 5) continue;

                $bulanText = strtolower(trim($sheetData[$i][4]));
                [$namaBulan, $tahun] = explode(' ', $bulanText);

                $bulan = $bulanMap[$namaBulan] ?? '01';

                Penjualan::create([
                    'kode_produk' => $sheetData[$i][1],
                    'nama_produk' => $sheetData[$i][2],
                    'jumlah' => (int) $sheetData[$i][3],
                    'bulan' => $tahun . '-' . $bulan . '-01',
                ]);

                $count++;
            }
        }

        return redirect()->back()->with('success', "✅ Berhasil import $count penjualan!");
    }
}
