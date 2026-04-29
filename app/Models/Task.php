<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'is_done'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}