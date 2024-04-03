<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'matter_id',
        'sub_matter_id',
        'office_id',
        'entry_date',
        'duration',
        'narrative',
        'template_name',
        'is_template',
        'is_draft',
        'is_billable',
    ];

    protected $with = ['clients', 'submatters', 'offices'];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function matters()
    {
        return $this->belongsTo(Matter::class, 'matter_id', 'id');
    }

    public function submatters()
    {
        return $this->belongsTo(SubMatter::class, 'sub_matter_id', 'id');
    }

    public function offices()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
