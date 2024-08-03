<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'product_images';

    protected $fillable = [
        'p_id',
        'image'
    ];
}