<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EclatResultDetail extends Model
{
    use HasFactory;
    protected $table = 'eclat_result_details';
    protected $fillable = [
        'obat_id',
        'eclat_result_id',
    ];

    public function eclatResult(): BelongsTo
    {
        return $this->belongsTo(EclatResult::class, 'eclat_result_id');
    }
    public function obatResult(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
