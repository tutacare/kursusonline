<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasEncryptedId;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
