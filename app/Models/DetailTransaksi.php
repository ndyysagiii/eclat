<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'obat_id',
        'transaksi_id',
    ];

    protected $table = 'detail_transaksi';

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
