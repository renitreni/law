<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseCourt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'law_cases_id',
        'court_name',
        'court_date',
        'court_address',
    ];

    public function case() : BelongsTo
    {
        return $this->belongsTo(LawCase::class,'law_cases_id','id');
    }


}
