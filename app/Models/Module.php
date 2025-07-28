<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasEncryptedId;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, HasEncryptedId;

    protected $fillable = [
        'course_id',
        'title',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class)->orderBy('order');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
