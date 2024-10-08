<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribes extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'subscribed_id'];
    public $timestamps = false; # Disable timestamps

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
