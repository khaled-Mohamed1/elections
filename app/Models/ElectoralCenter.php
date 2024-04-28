<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ElectoralCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'ec_name',
        'ec_NO',
        'user_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function individuals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Individual::class, 'electoral_id', 'id');
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
