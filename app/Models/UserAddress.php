<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address', 
        'city',
        'post_code',
        'phone_number',
        'notes',
        'user_id',
    ];

    protected $hidden = ['user_id', 'created_at', 'updated_at'];
}
