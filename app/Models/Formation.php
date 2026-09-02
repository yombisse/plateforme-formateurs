<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Formation extends Model
{
    use HasFactory;

    protected $appends = ['date', 'duration', 'remaining_places', 'image_url'];

    protected $fillable = [
        'user_id',
        'slug',
        'category',
        'mode',
        'level',
        'title',
        'trainer_name',
        'short_description',
        'full_description',
        'status',
        'start_date',
        'end_date',
        'location',
        'duration',
        'remaining_places',
        'max_places',
        'price',
        'currency',
        'delivery_link',
        'image',
        'image_public_id',
        'objectives',
        'modules',
        'learning_points',
        'practical_info',
        'about',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'max_places' => 'integer',
        'price' => 'integer',
        'objectives' => 'array',
        'modules' => 'array',
        'learning_points' => 'array',
        'practical_info' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function averageRating()
    {
        return $this->evaluations()->avg('rating') ?? 0;
    }

    public function getRemainingPlacesAttribute(): int
    {
        return max(0, $this->max_places - $this->inscriptions()->where('statut_inscription', 'valide')->count());
    }

    public function getDateAttribute(): ?string
    {
        return $this->start_date ? $this->start_date->format('d M Y') : null;
    }

    public function getDurationAttribute(): ?string
    {
        if (! $this->start_date || ! $this->end_date) {
            return null;
        }

        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $days = $start->diffInDays($end);

        if ($days < 7) {
            return $days.' jour'.($days > 1 ? 's' : '');
        } elseif ($days < 30) {
            $weeks = ceil($days / 7);

            return $weeks.' semaine'.($weeks > 1 ? 's' : '');
        } else {
            $months = ceil($days / 30);

            return $months.' mois';
        }
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://') || str_starts_with($this->image, '/storage/')
            ? $this->image
            : Storage::disk('public')->url($this->image);
    }
}
