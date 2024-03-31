<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'law_cases_id',
        'name',
        'contact',
        'age',
        'birthday',
        'company',
        'role',
        'attorney'
    ];

    public function case() : BelongsTo
    {
        return $this->belongsTo(LawCase::class,'law_cases_id','id');
    }
}
