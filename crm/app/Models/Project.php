<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'status',
        'description',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
