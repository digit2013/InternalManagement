<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskHead extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'task_heads';

    protected $fillable = [
        'id',
        'name',
        'description',
        'created_by',
        'updated_by',
        'status'
    ];

    public function taskdetails(): HasMany
    {
        return $this->hasMany(TaskDetail::class);
    }
}
