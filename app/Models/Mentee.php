<?php

namespace App\Models;

use App\Models\Mentor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mentee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }
}
