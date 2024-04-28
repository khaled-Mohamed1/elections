<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamLeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'tl_name',
        // 'tl_team_name',
        'tl_phone_NO1',
        'tl_phone_NO2',
        'address',
        'user_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function individuals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Individual::class, 'team_leader_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }
}
