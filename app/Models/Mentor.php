<?php

namespace App\Models;

use App\Models\Mentee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id'
    ];

    public function mentees()
    {
        return $this->hasMany(Mentee::class);
    }
}
