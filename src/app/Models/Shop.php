<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'manager_id',
        'name',
        'area',
        'genre',
        'max_capacity',
        'description',
        'image_url',
        'email',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavoritedBy($user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
