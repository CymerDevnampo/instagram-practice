<?php

namespace App;

use App\Mail\NewUserWelcomeMail;
use Illuminate\Foundation\Bootstrap\BootProviders;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot() // para ni sa blank nga profile ig redirect
    {
        parent::boot();

        static::created(function ($user) {
            $user->profile()->create([
                'title'=> $user->name,
            ]);

            Mail::to($user->email)->send(new NewUserWelcomeMail ());
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at','desc');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
