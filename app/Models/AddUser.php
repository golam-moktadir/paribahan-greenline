<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddUser extends Model
{
    /** @use HasFactory<\Database\Factories\AddUserFactory> */
    use HasFactory;

    protected $table = "adduser";

    protected $primaryKey = "user_id";

    protected $fillable = [
        "user_id",
        "user_password",
        "user_new_password",
        "user_save_time"
    ];

    protected $hidden = [
        'user_password',
        'user_new_password',
    ];

    protected function casts(): array
    {
        return [
            'user_new_password' => 'hashed',
        ];
    }

}
