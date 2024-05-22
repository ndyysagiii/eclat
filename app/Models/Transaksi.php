<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_transaksi',
    ];

    protected $table = 'transaksi';

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
