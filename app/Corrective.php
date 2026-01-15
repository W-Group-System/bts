<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corrective extends Model
{
    public function assignTo()
    {
        return $this->belongsTo(User::class,'assign_to','id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function assignBy()
    {
        return $this->belongsTo(User::class,'assign_by','id');
    }
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    public function correctiveBoard()
    {
        return $this->belongsTo(CorrectiveBoard::class);
    }
    public function correctiveAttachment()
    {
        return $this->hasMany(CorrectiveAttachment::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
