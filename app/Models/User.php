<?php

namespace App\Models;

use Database\Factories\UserFactory;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'specialty', 'location', 'phone', 'bio', 'profile_photo', 'profile_photo_public_id', 'hero_image', 'hero_image_public_id', 'instagram_url', 'linkedin_url', 'website_url', 'tags', 'formations_count', 'students_count'])]
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

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->profile_photo);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->hero_image);
    }

    private function mediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : Storage::disk('public')->url($path);
    }
}
