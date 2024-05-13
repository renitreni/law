<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseClient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'law_cases_id',
        'client_name',
        'client_contact',
        'client_email',
        'client_company',
    ];

    public function case() : BelongsTo
    {
        return $this->belongsTo(LawCase::class,'law_cases_id','id');
    }
}
