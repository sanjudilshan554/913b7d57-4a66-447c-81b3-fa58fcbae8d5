<?php

namespace App\Services\Reports;

use App\Contracts\ReportInterface;
use App\Services\DataLoader;

class DiagnosticReport implements ReportInterface
{    
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct(
        private DataLoader $dataLoader
    ) {}
    
    /**
     * Method generate
     *
     * @param string $studentId [explicite description]
     *
     * @return string
     */
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
            return strtotime($b['completed']) - strtotime($a['completed']);
        });
        
        $latestResponse = $responses[0];
        
        $assessment = $this->dataLoader->getAssessment($latestResponse['assessmentId']);
        
        $totalCorrect = 0;
        $totalQuestions = count($latestResponse['responses']);
        $strandScores = [];

        foreach ($latestResponse['responses'] as $response) {
            $question = $this->dataLoader->getQuestion($response['questionId']);
            $strand = $question['strand'];
            $isCorrect = $question['config']['key'] === $response['response'];

            if (!isset($strandScores[$strand])) {
                $strandScores[$strand] = ['correct' => 0, 'total' => 0];
            }

            $strandScores[$strand]['total']++;
            if ($isCorrect) {
                $strandScores[$strand]['correct']++;
                $totalCorrect++;
            }
        }
        
        $completedDate = \DateTime::createFromFormat('d/m/Y H:i:s', $latestResponse['completed']);
        $formattedDate = $completedDate->format('jS F Y g:i A');

        $output = "{$student['firstName']} {$student['lastName']} recently completed {$assessment['name']} assessment on {$formattedDate}\n";
        $output .= "He got {$totalCorrect} questions right out of {$totalQuestions}. Details by strand given below:\n\n";

        foreach ($strandScores as $strand => $scores) {
            $output .= "{$strand}: {$scores['correct']} out of {$scores['total']} correct\n";
        }

        return $output;
    }
}