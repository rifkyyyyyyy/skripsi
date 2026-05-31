<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    protected $table = 'prediksi';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'alpha',
        'beta',
        'periode_prediksi',
        'mad',
        'mase',
        'mape',
        'peramalan',
        'tanggal'
    ];
}