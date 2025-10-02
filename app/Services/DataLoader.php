<?php

namespace App\Services;

class DataLoader
{
    private array $students = [];
    private array $assessments = [];
    private array $questions = [];
    private array $responses = [];
    
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->loadData();
    }
    
    /**
     * Method loadData
     *
     * @return void
     */
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
    
    /**
     * Method getStudent
     *
     * @param string $id [explicite description]
     *
     * @return array
     */
    public function getStudent(string $id): ?array
    {
        foreach ($this->students as $student) {
            if ($student['id'] === $id) {
                return $student;
            }
        }
        return null;
    }
    
    /**
     * Method getQuestion
     *
     * @param string $id [explicite description]
     *
     * @return array
     */
    public function getQuestion(string $id): ?array
    {
        foreach ($this->questions as $question) {
            if ($question['id'] === $id) {
                return $question;
            }
        }
        return null;
    }
    
    /**
     * Method getAssessment
     *
     * @param string $id [explicite description]
     *
     * @return array
     */
    public function getAssessment(string $id): ?array
    {
        foreach ($this->assessments as $assessment) {
            if ($assessment['id'] === $id) {
                return $assessment;
            }
        }
        return null;
    }
    
    /**
     * Method getStudentResponses
     *
     * @param string $studentId [explicite description]
     *
     * @return array
     */
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
    
    /**
     * Method getAllQuestions
     *
     * @return array
     */
    public function getAllQuestions(): array
    {
        return $this->questions;
    }
}