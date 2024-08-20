<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'person';

    protected $fillable = [
        'id',
        'name',
        'countryCode',
        'stateCode',
        'city',
        'address',
        'occupation',
        'mail',
        'phonecode',
        'phone',
        'currency',
        'profession',
        'gender',
        'material',
        'age',
        'avgIncome',
        'created_by',
        'updated_by',
        'status'
    ];
}
