<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role',
        'membership_status',
        'selected_plan',
        'provider',
        'provider_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIsMemberAttribute(): bool
    {
        return $this->membership_status === 'member';
    }



    protected $hidden = ['password', 'remember_token'];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActiveMember(): bool
    {
        return $this->membership_status === 'active';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
