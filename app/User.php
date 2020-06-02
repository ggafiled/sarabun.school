<?php

namespace App;

use Cache;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use \HighIdeas\UsersOnline\Traits\UsersOnlineTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminlte_image()
    {
        return (Auth::user()->image) ? Auth::user()->image : 'https://www.lkautoshop.com/images/default_car.jpg';
    }

    public function document()
    {
        return $this->hasMany(Document::class);
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}