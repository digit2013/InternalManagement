<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'sales';

    protected $fillable = [
        'id',
        'invoice_id',
        'warehouse_id',
        'stock_id',
        'unit_price',
        'discount_amt',
        'amount',
        'qty',
        'created_by',
        'updated_by',
        'status'
    ];
}
