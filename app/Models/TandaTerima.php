<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TandaTerima extends Model
{
    public function tandaTerima()
    {
        return $this->hasMany(TandaTerima::class);
    }
}
