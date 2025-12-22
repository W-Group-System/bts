<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectiveBoard extends Model
{
    public function corrective()
    {
        return $this->hasMany(Corrective::class);
    }
}
