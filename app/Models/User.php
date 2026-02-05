<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // ========== ADD THESE 4 METHODS ==========
    
    // 1. Get friend requests sent by this user
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    // 2. Get friend requests received by this user
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    // 3. Check if friendship exists with another user
    public function friendshipWith(User $user)
    {
        return \App\Models\Friendship::where(function($query) use ($user) {
                $query->where('sender_id', $this->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $this->id);
            })
            ->first();
    }

    // 4. Get all accepted friends
    public function friends()
    {
        $acceptedAsSender = $this->sentFriendRequests()
            ->where('status', 'accepted')
            ->get()
            ->pluck('receiver_id');

        $acceptedAsReceiver = $this->receivedFriendRequests()
            ->where('status', 'accepted')
            ->get()
            ->pluck('sender_id');

        $friendIds = $acceptedAsSender->merge($acceptedAsReceiver);

        return User::whereIn('id', $friendIds);
    }
}