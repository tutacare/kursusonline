<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentQuizTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed'); // Seed the database with roles and other necessary data
    }

    /** @test */
    public function a_student_can_start_a_quiz()
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $quiz = Quiz::factory()->create(['duration' => 10]); // 10 minutes duration

        $response = $this->actingAs($student)->postJson(route('student.quizzes.start', $quiz->encrypted_id), ['_token' => csrf_token()]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['started_at', 'quiz_duration']);

        $this->assertDatabaseHas('quiz_results', [
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'is_completed' => false,
        ]);
    }

    /** @test */
    public function a_student_can_submit_a_quiz_within_time_limit()
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $quiz = Quiz::factory()->create(['duration' => 10]); // 10 minutes duration

        // Manually create a quiz result with a started_at time
        $startedAt = now()->subMinutes(5); // Started 5 minutes ago
        QuizResult::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 0,
            'started_at' => $startedAt,
            'is_completed' => false,
        ]);

        // Assuming the quiz has questions and answers for scoring
        $question = Question::factory()->for($quiz)->create();
        $correctAnswer = Answer::factory()->for($question)->create(['is_correct' => true]);
        $wrongAnswer = Answer::factory()->for($question)->create(['is_correct' => false]);

        $response = $this->actingAs($student)->post(route('student.quizzes.submit', $quiz->encrypted_id), [
            'question_' . $question->id => $correctAnswer->id,
        ]);

        $response->assertRedirect(route('student.courses.show', $quiz->module->course->encrypted_id))
                 ->assertSessionHas('success');

        $this->assertDatabaseHas('quiz_results', [
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 1,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function a_student_cannot_submit_a_quiz_after_time_limit_expires()
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $quiz = Quiz::factory()->create(['duration' => 1]); // 1 minute duration

        // Manually create a quiz result with a started_at time that has expired
        $startedAt = now()->subMinutes(2); // Started 2 minutes ago (1 minute quiz)
        QuizResult::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 0,
            'started_at' => $startedAt,
            'is_completed' => false,
        ]);

        // Assuming the quiz has questions and answers for scoring
        $question = Question::factory()->for($quiz)->create();
        $correctAnswer = Answer::factory()->for($question)->create(['is_correct' => true]);

        $response = $this->actingAs($student)->post(route('student.quizzes.submit', $quiz->encrypted_id), [
            'question_' . $question->id => $correctAnswer->id,
        ]);

        $response->assertRedirect()
                 ->assertSessionHas('error', 'Waktu pengerjaan kuis telah habis.');

        $this->assertDatabaseHas('quiz_results', [
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'is_completed' => false, // Should not be completed
        ]);
    }
}