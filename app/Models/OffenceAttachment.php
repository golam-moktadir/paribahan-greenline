<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffenceAttachment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'offence_id',
        'path',
        'original_name',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function offence()
    {
        return $this->belongsTo(Offence::class);
    }
}
