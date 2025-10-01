<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DataLoader;

class DataLoaderTest extends TestCase
{
    private DataLoader $dataLoader;

    // Set up the DataLoader instance before each test
    protected function setUp(): void
    {
        parent::setUp();
        $this->dataLoader = new DataLoader();
    }

    // Basic tests to ensure data loading and retrieval works as expected
    public function test_can_load_student_data()
    {
        $student = $this->dataLoader->getStudent('student1');
        
        $this->assertNotNull($student);
        $this->assertEquals('Tony', $student['firstName']);
        $this->assertEquals('Stark', $student['lastName']);
    }

    // Test for an invalid student ID
    public function test_returns_null_for_invalid_student()
    {
        $student = $this->dataLoader->getStudent('invalid_id');
        
        $this->assertNull($student);
    }

    // Test to ensure question data is loaded correctly
    public function test_can_load_question_data()
    {
        $question = $this->dataLoader->getQuestion('numeracy1');
        
        $this->assertNotNull($question);
        $this->assertArrayHasKey('stem', $question);
        $this->assertArrayHasKey('strand', $question);
    }

    // Test to ensure student responses are loaded correctly
    public function test_can_get_student_responses()
    {
        $responses = $this->dataLoader->getStudentResponses('student1');
        
        $this->assertIsArray($responses);
        $this->assertNotEmpty($responses);
        
        // Check that all responses have 'completed' field
        foreach ($responses as $response) {
            $this->assertArrayHasKey('completed', $response);
        }
    }

    // Test to ensure only completed assessments are returned
    public function test_only_returns_completed_assessments()
    {
        $responses = $this->dataLoader->getStudentResponses('student1');
        
        foreach ($responses as $response) {
            $this->assertArrayHasKey('completed', $response);
            $this->assertNotEmpty($response['completed']);
        }
    }
}