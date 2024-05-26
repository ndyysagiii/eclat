<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EclatCalculation extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_dari', 'tanggal_sampai', 'min_support', 'min_confidance'];

    public function results()
    {
        return $this->hasMany(EclatResult::class);
    }

    public function resultDetails()
    {
        return $this->hasMany(EclatResultDetail::class);
    }
}
