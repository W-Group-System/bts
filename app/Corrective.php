<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corrective extends Model
{
    public function assign_to()
    {
        return $this->belongsTo(User::class,'assign_to','id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
