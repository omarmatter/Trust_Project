<?php

 namespace Modules\User\Entities;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Modules\Order\Entities\Cart;
use Modules\Order\Entities\order;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ADMIN = 1;
    public const USER = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'gender',
         'roles',
        'password',
    ];
    // protected static function booted()
    // {
    //     static::addGlobalScope(new AdminTypeScope);
    // }

    public function scopeIsAdmin(Builder $builder)
    {
        $builder->where('roles', '=', self::ADMIN);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function routeNotificationForSms(){
        return $this->phone_number;
    }

public function cart()
{
    return $this->hasOne(Cart::class);
}
 public function orders()
 {
     return $this->hasMany(order::class );
 }
 public function deviceTokens(){
        return $this->hasMany(DeviceToken::class);
 }
    public function routeNotificationForFcm()
    {
        return $this->deviceTokens()->pluck('token')->toArray();
    }

    public function createToken(string $name, $FcmToken, array $abilities = ['*'])
    {
        $token = $this->tokens()->create([
            'name'      => $name,
            'token'     => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'FcmToken'   => $FcmToken,
        ]);

          return new NewAccessToken($token, $token->getKey().'|'.$plainTextToken);
    }


}
