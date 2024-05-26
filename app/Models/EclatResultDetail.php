<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EclatResultDetail extends Model
{
    use HasFactory;
    protected $fillable = ['eclat_calculation_id', 'eclat_result_id', 'obat_id'];

    public function result()
    {
        return $this->belongsTo(EclatResult::class);
    }

    public function calculation()
    {
        return $this->belongsTo(EclatCalculation::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
