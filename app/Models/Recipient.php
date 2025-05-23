<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'recipients';

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'student_id');
    }
}
