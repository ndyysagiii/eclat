<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EclatResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'eclat_calculation_id', 'itemset', 'support', 'confidence',
        'result_type', 'keterangan', 'lift_ratio'
    ];

    public function calculation()
    {
        return $this->belongsTo(EclatCalculation::class);
    }

    public function details()
    {
        return $this->hasMany(EclatResultDetail::class);
    }
}
