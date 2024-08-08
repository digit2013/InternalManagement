<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'task_details';

    protected $fillable = [
        'id',
        't_id',
        'name',
        'description',
        'u_id',
        'assign_start_date',
        'assign_end_date',
        'finish_start_date',
        'finish_end_date',
        'status'
    ];
}
