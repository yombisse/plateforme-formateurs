<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'comment',
        'is_public',
        'guest_name',
        'guest_email',
        'guest_phone',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?? 'Anonyme';
    }
}
