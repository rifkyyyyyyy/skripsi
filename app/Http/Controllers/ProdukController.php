<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', '20_terbaru');
        $search = $request->get('search');
        $totalProduk = Produk::count();

        $produks = Produk::when($search, function ($q) use ($search) {
                $q->where('kode_produk', 'like', "%$search%")
                  ->orWhere('nama_produk', 'like', "%$search%")
                  ->orWhere('stok', 'like', "%$search%")
                  ->orWhere('bulan', 'like', "%$search%");
            })
            ->when($filter === '7_hari', function ($q) {
                $q->where('created_at', '>=', now()->subDays(7));
            })
            ->when($filter === '1_bulan', function ($q) {
                $q->where('created_at', '>=', now()->subMonth());
            })
            ->orderBy('created_at', 'desc')
            ->when($filter === '20_terbaru', function ($q) {
                $q->take(20);
            })
            ->get();

        return view('dataProduk', compact(
            'produks',
            'filter',
            'search',
            'totalProduk'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_produk' => 'required|string|max:50|unique:produks,kode_produk',
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer',
            'bulan' => 'required|date',
        ]);

        Produk::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
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

                $bulanText = strtolower(trim($row[4]));
                [$namaBulan, $tahun] = explode(' ', $bulanText);

                $bulan = $bulanMap[$namaBulan] ?? '01';

                Produk::create([
                    'kode_produk' => trim($row[1]),
                    'nama_produk' => trim($row[2]),
                    'stok' => (int) trim($row[3]),
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

                Produk::create([
                    'kode_produk' => $sheetData[$i][1],
                    'nama_produk' => $sheetData[$i][2],
                    'stok' => (int) $sheetData[$i][3],
                    'bulan' => $tahun . '-' . $bulan . '-01',
                ]);

                $count++;
            }
        }

        return redirect()->back()->with('success', "✅ Berhasil import $count produk!");
    }
}