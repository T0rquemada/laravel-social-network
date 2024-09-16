<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model {
    use HasFactory;
    protected $table = 'blackList'; // Specify the table name
    protected $fillable = ['user_id', 'blocked_id'];
    public $timestamps = false; # Disable timestamps
}
