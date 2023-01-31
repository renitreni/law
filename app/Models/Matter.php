<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matter extends Model
{
    use HasFactory;

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
