<?php

namespace App\Services\Reports;

use App\Contracts\ReportInterface;
use App\Services\DataLoader;

class ProgressReport implements ReportInterface
{
    public function __construct(
        private DataLoader $dataLoader
    ) {}

    public function generate(string $studentId): string
    {
        $student = $this->dataLoader->getStudent($studentId);
        
        if (!$student) {
            throw new \Exception("Student not found: {$studentId}");
        }

        $responses = $this->dataLoader->getStudentResponses($studentId);

        if (empty($responses)) {
            throw new \Exception("No completed assessments found for student: {$studentId}");
        }

        usort($responses, function($a, $b) {
            return strtotime($a['completed']) - strtotime($b['completed']);
        });

        $assessment = $this->dataLoader->getAssessment($responses[0]['assessmentId']);
        $totalAttempts = count($responses);

        $output = "{$student['firstName']} {$student['lastName']} has completed {$assessment['name']} assessment {$totalAttempts} times in total. Date and raw score given below:\n\n";

        $scores = [];
        foreach ($responses as $response) {
            $completedDate = \DateTime::createFromFormat('d/m/Y H:i:s', $response['completed']);
            $date = $completedDate->format('jS F Y');
            $rawScore = $response['results']['rawScore'];
            $totalQuestions = count($response['responses']);
            
            $output .= "Date: {$date}, Raw Score: {$rawScore} out of {$totalQuestions}\n";
            $scores[] = $rawScore;
        }

        $improvement = end($scores) - reset($scores);
        $output .= "\n{$student['firstName']} {$student['lastName']} got {$improvement} more correct in the recent completed assessment than the oldest";

        return $output;
    }
}