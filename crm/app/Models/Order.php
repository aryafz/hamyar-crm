<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'type',
        'status',
        'amount',
        'deposit',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
