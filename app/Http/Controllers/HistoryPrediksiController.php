<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistoryPrediksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prediksi::orderBy('updated_at', 'DESC');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('periode_prediksi', 'like', '%' . $search . '%')
                  ->orWhere('tanggal', 'like', '%' . $search . '%');
            });
        }

        $items = $query->paginate(10)->appends(['search' => $request->search]);

        return view('history_prediksi', compact('items'));
    }

    public function destroy($id)
    {
        $item = Prediksi::findOrFail($id);
        $item->delete();

        return redirect()->route('history.index')
            ->with('success', 'Data history prediksi berhasil dihapus.');
    }

    public function exportPdf($id)
    {
        $it = Prediksi::findOrFail($id);

        // Build history data dari penjualan
        $sales = Penjualan::where('kode_produk', $it->kode_produk)->get();
        $monthly = [];
        foreach ($sales as $s) {
            if (empty($s->bulan)) continue;
            $key = Carbon::parse($s->bulan)->format('Y-m');
            $monthly[$key] = ($monthly[$key] ?? 0) + (int) $s->jumlah;
        }
        ksort($monthly);
        $hLabels = array_keys($monthly);
        $hData   = array_values($monthly);

        // Build forecast labels
        $fData   = json_decode($it->peramalan, true) ?? [];
        $fLabels = [];
        if (!empty($hLabels)) {
            $lastLabel = end($hLabels);
            $lastMonth = Carbon::createFromFormat('Y-m', $lastLabel)->startOfMonth();
            for ($i = 1; $i <= $it->periode_prediksi; $i++) {
                $fLabels[] = $lastMonth->copy()->addMonths($i)->format('Y-m');
            }
        }

        $bulanIndo = ["Januari","Februari","Maret","April","Mei","Juni",
                      "Juli","Agustus","September","Oktober","November","Desember"];

        $html  = '<!DOCTYPE html><html><head><meta charset="UTF-8">';
        $html .= '<style>';
        $html .= 'body{font-family:Arial,sans-serif;font-size:12px;color:#222;margin:30px;}';
        $html .= 'h2{text-align:center;color:#304c89;margin-bottom:4px;}';
        $html .= 'p.sub{text-align:center;color:#666;margin:0 0 20px;}';
        $html .= '.info-box{border:1px solid #ccc;border-radius:6px;padding:10px 16px;margin-bottom:18px;background:#f9f9f9;}';
        $html .= '.info-box table{width:100%;border-collapse:collapse;}';
        $html .= '.info-box td{padding:4px 8px;}';
        $html .= '.info-box td:first-child{font-weight:bold;width:160px;color:#304c89;}';
        $html .= 'h4{color:#304c89;margin:18px 0 8px;}';
        $html .= 'table.tbl{width:100%;border-collapse:collapse;margin-bottom:16px;}';
        $html .= 'table.tbl th{background:#304c89;color:#fff;padding:8px;text-align:center;font-size:11px;}';
        $html .= 'table.tbl td{padding:7px;text-align:center;border-bottom:1px solid #ddd;font-size:11px;}';
        $html .= 'table.tbl tr:nth-child(even) td{background:#f0f4ff;}';
        $html .= '.footer{text-align:center;color:#aaa;font-size:10px;margin-top:30px;}';
        $html .= '</style></head><body>';

        $html .= '<h2>Laporan History Prediksi DES (Holt)</h2>';
        $html .= '<p class="sub">Dicetak pada: ' . now()->format('d F Y, H:i') . ' WIB</p>';

        $html .= '<div class="info-box"><table>';
        $html .= '<tr><td>Nama Produk</td><td>: ' . htmlspecialchars($it->nama_produk) . '</td></tr>';
        $html .= '<tr><td>Alpha (α)</td><td>: ' . $it->alpha . '</td></tr>';
        $html .= '<tr><td>Beta (β)</td><td>: ' . $it->beta . '</td></tr>';
        $html .= '<tr><td>Periode Prediksi</td><td>: ' . $it->periode_prediksi . ' Bulan</td></tr>';
        $html .= '<tr><td>MAD</td><td>: ' . $it->mad . '</td></tr>';
        $html .= '<tr><td>MSE</td><td>: ' . $it->mse . '</td></tr>';
        $html .= '<tr><td>MAPE</td><td>: ' . number_format($it->mape, 1) . '%</td></tr>';
        $html .= '<tr><td>Tanggal Prediksi</td><td>: ' . $it->tanggal . '</td></tr>';
        $html .= '</table></div>';

        $html .= '<h4>Data Penjualan Aktual</h4>';
        $html .= '<table class="tbl"><thead><tr><th>No</th><th>Bulan</th><th>Penjualan</th></tr></thead><tbody>';
        foreach ($hLabels as $i => $lbl) {
            $parts = explode('-', $lbl);
            $nm = $bulanIndo[((int)$parts[1]) - 1] . ' ' . $parts[0];
            $no = $i + 1;
            $html .= "<tr><td>$no</td><td>$nm</td><td>" . number_format($hData[$i]) . "</td></tr>";
        }
        $html .= '</tbody></table>';

        $html .= '<h4>Hasil Peramalan (' . $it->periode_prediksi . ' Bulan ke Depan)</h4>';
        $html .= '<table class="tbl"><thead><tr><th>No</th><th>Bulan</th><th>Forecast</th><th>Rekomendasi (Ceil)</th></tr></thead><tbody>';
        foreach ($fLabels as $i => $lbl) {
            $parts = explode('-', $lbl);
            $nm    = $bulanIndo[((int)$parts[1]) - 1] . ' ' . $parts[0];
            $val   = $fData[$i] ?? 0;
            $no    = $i + 1;
            $html .= "<tr><td>$no</td><td>$nm</td><td>" . number_format($val, 2) . "</td><td>" . ceil($val) . "</td></tr>";
        }
        $html .= '</tbody></table>';
        $html .= '<div class="footer">Sistem Prediksi Penjualan &mdash; Double Exponential Smoothing (Holt)</div>';
        $html .= '</body></html>';

        // Return as downloadable HTML-to-PDF using browser print
        $filename = 'prediksi_' . str_replace(' ', '_', $it->nama_produk) . '_' . $it->tanggal . '.html';
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}