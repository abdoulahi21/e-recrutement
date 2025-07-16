<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function apply(){
        return $this->hasMany(Apply::class);
    }
}
