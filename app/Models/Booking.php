<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;


    public function slot(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Slot::class);
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Customer::class);
    }

}
