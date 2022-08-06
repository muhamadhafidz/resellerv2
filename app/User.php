<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username', 'no_hp', 'img_user', 'alamat', 'email', 'password',
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

    public function keranjang()
    {
        return $this->hasMany('App\Keranjang', 'user_id');
    }
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'user_id');
    }
    public function user_points()
    {
        return $this->hasMany('App\User_point', 'user_id');
    }
}
