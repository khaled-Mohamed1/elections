<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Individual extends Model
{
    use HasFactory;

    protected $fillable = [
        'i_name',
        'i_NO',
        'i_phone_NO',
        'address',
        'electoral_id',
        'team_leader_id',
        'user_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the User ElectoralCenter
    public function electoralCenter()
    {
        return $this->belongsTo(ElectoralCenter::class, 'electoral_id');
    }

    // Define the relationship with the User TeamLeader
    public function teamLeader()
    {
        return $this->belongsTo(TeamLeader::class, 'team_leader_id');
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
