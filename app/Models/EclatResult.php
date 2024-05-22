<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EclatResult extends Model
{
    use HasFactory;
    protected $table = 'eclat_result';
    protected $fillable = [
        'tanggal_dari',
        'tanggal_sampai',
        'min_support',
        'min_confidance',
        'itemset',
        'lift_ratio',
        'support',
        'confidence',
        'result_type',
        'keterangan'
    ];
    public function eclatResultDetails(): HasMany
    {
        return $this->hasMany(EclatResultDetail::class);
    }
}
