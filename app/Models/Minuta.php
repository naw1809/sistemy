<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Minuta extends Model
{
    use HasFactory;

    protected $fillable = [
        'bast_id',
        'user_id',
        'no_minuta',
        'jenis_minuta',
        'pejabat_bank',
        'nama_debitur',
        'developer',
        'tgl_minuta',
        'note',
    ];

    public function bast()
    {
        return $this->belongsTo(Bast::class, 'bast_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
