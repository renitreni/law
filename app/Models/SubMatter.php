<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubMatter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'matter_id',
        'name',
        'code',
    ];

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }
}
