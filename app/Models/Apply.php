<?php

namespace App\Models;

use App\Observers\ApplyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Apply extends Model
{
    use HasFactory;

    protected $table = 'apply';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'accepted' => 'Acceptée',
            'rejected' => 'Rejetée',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get the status color.
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'accepted' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }
}
