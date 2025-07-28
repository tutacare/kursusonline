<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory, HasEncryptedId;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'duration',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }
}