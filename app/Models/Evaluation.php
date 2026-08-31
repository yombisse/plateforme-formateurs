<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'user_id',
        'rating',
        'comment',
        'guest_name',
        'guest_email',
        'guest_phone',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?? 'Anonyme';
    }
}
