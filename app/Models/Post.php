<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    // Relationship to the User model
    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['text', 'user_id'];
}
