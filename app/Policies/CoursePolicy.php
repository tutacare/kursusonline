<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function view(User $user, Course $course)
    {
        return $user->courses()->where('course_id', $course->id)->exists();
    }
}
