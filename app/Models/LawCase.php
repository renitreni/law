<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'case_plaintiff',
        'case_defendant',
        'case_description',
        'case_category',
        'case_status',
        'case_attorney',
        'case_date',
    ];

    public function client() : HasOne
    {
        return $this->hasOne(CaseClient::class,'law_cases_id','id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(CaseFiles::class,'law_cases_id','id');
    }
    public function court() : HasMany
    {
        return $this->hasMany(CaseCourt::class,'law_cases_id','id');
    }
}
