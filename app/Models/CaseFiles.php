<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseFiles extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'law_cases_id',
        'filename',
        'uploaded_by'
    ];

    public function case():BelongsTo
    {
        return $this->belongsTo(LawCase::class,'law_cases_id','id');
    }
}
