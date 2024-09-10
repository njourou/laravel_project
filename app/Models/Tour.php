<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'slots', 'available_slots', 'date', 'image', 'destination_id'];


    /**
     * Get the destination that the tour belongs to.
     */
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get all bookings for the tour.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
