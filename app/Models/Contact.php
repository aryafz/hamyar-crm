<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'job_title',
        'email',
        'mobile',
        'province',
        'city',
        'address',
        'notes',
        'type'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function interactions()
    {
        return $this->hasMany(Interaction::class)->latest();
    }
}
