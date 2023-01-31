<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMatter extends Model
{
    use HasFactory;

    protected $fillable = [
        'matter_id',
        'name',
        'code',
    ];
}
