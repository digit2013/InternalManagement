<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'invoices';

    protected $fillable = [
        'id',
        'warehouse_id',
        'invoice_id',
        'customer_id',
        'discount_id',
        'commission',
        'price_type',
        'created_by',
        'updated_by',
        'status'
    ];
}
