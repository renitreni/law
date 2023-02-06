<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
    ];

    protected $with = [
        'subMatters'
    ];

    public function subMatters()
    {
        return $this->hasMany(SubMatter::class, 'matter_id', 'id');
    }
}
