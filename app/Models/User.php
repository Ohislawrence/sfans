<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'display_photo',
        'cover_photo',
        'gender',
        'sexual_orientation',
        'bio',
        'instagram',
        'tictok',
        'x',
        'website',
        'google_id',
        'twitter_id',
        'facebook_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    public function convo()
    {
        return $this->hasMany(Conversation::class);
    }

    public function chatslut()
    {
        return $this->hasOne(Chatbot::class, 'username', 'username');
    }

    public function chatsAsUser()
    {
        return $this->hasMany(Chat::class, 'user_id');
    }

    public function chatsAsBot()
    {
        return $this->hasMany(Chat::class, 'bot_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isBot()
    {
        return $this->hasRole('slut'); // Assuming you're using role management
    }

    public function botModel()
    {
        return $this->hasOne(BotModel::class);
    }
}
