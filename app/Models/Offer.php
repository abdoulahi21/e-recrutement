<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function candidates(){
        return $this->belongsToMany(User::class,'apply')->withTimestamps();
    }

    public function apply()
    {
        return $this->hasMany(Apply::class);
    }

}