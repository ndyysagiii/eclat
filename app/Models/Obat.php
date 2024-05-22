<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
    ];

    protected $table = 'obat';

    public function detail(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class);
    }
    public function eclatResultDetails(): HasMany
    {
        return $this->hasMany(EclatResultDetail::class);
    }
}
