<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe_bast',
        'tgl_diserahkan',
        'tgl_diterima',
        'status',
        'kc_btn',
        'keterangan',
    ];

    public function minutas()
    {
        return $this->hasMany(Minuta::class, 'bast_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
