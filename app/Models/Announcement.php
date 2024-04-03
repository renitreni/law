<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'is_read',
        'description',
        'user_id',
        'type', // reminder
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
