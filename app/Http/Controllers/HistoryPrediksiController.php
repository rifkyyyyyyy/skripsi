<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;

class HistoryPrediksiController extends Controller
{
    public function index()
    {
        $items = Prediksi::orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('history_prediksi', compact('items'));
    }
}