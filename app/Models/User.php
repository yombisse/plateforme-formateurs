<?php

namespace App\Models;

use App\Models\Evaluation;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Recommandation;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'specialty', 'location', 'phone', 'bio', 'profile_photo', 'hero_image', 'instagram_url', 'linkedin_url', 'website_url', 'tags', 'formations_count', 'students_count'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function recommandationsAsUser()
    {
        return $this->hasMany(Recommandation::class, 'user_id');
    }

    public function recommandationsAsTrainer()
    {
        return $this->hasMany(Recommandation::class, 'trainer_id');
    }

    public function recommandations()
    {
        return $this->recommandationsAsTrainer();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tags' => 'array',
        ];
    }
}
