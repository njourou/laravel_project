<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'number_of_tickets',
        'full_name',
        'email',
        'phone',
        'terms_accepted',
    ];

    /**
     * Get the tour that the booking belongs to.
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
