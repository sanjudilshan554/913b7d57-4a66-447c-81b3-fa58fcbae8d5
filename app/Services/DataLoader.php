<?php

namespace App\Services;

class DataLoader
{
    private array $students = [];
    private array $assessments = [];
    private array $questions = [];
    private array $responses = [];

    public function __construct()
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        $dataPath = base_path('data');

        $this->students = json_decode(
            file_get_contents($dataPath . '/students.json'),
            true
        );

        $this->assessments = json_decode(
            file_get_contents($dataPath . '/assessments.json'),
            true
        );

        $this->questions = json_decode(
            file_get_contents($dataPath . '/questions.json'),
            true
        );

        $this->responses = json_decode(
            file_get_contents($dataPath . '/student-responses.json'),
            true
        );
    }

    public function getStudent(string $id): ?array
    {
        foreach ($this->students as $student) {
            if ($student['id'] === $id) {
                return $student;
            }
        }
        return null;
    }

    public function getQuestion(string $id): ?array
    {
        foreach ($this->questions as $question) {
            if ($question['id'] === $id) {
                return $question;
            }
        }
        return null;
    }

    public function getAssessment(string $id): ?array
    {
        foreach ($this->assessments as $assessment) {
            if ($assessment['id'] === $id) {
                return $assessment;
            }
        }
        return null;
    }

    public function getStudentResponses(string $studentId): array
    {
        $filtered = [];
        
        foreach ($this->responses as $response) { 
            if (isset($response['student']['id']) && 
                $response['student']['id'] === $studentId && 
                isset($response['completed'])) {
                $filtered[] = $response;
            }
        }
        
        return $filtered;
    }

    public function getAllQuestions(): array
    {
        return $this->questions;
    }
}