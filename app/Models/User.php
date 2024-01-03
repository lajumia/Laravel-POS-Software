<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['firstName','lastName','email','mobile','password','otp'];
    protected $attributes = ['otp'=>'0'];
    protected $hidden = ['password','otp'];

}
