<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Tour extends Model
{
    protected $fillable = ['name', 'description', 'price', 'slots', 'date', 'image', 'destination_id'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
