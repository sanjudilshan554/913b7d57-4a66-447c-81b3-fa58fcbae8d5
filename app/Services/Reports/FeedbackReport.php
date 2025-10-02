<?php

namespace App\Services\Reports;

use App\Contracts\ReportInterface;
use App\Services\DataLoader;

class FeedbackReport implements ReportInterface
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
        $wrongAnswers = [];

        foreach ($latestResponse['responses'] as $response) {
            $question = $this->dataLoader->getQuestion($response['questionId']);
            $isCorrect = $question['config']['key'] === $response['response'];

            if ($isCorrect) {
                $totalCorrect++;
            } else {
                $wrongAnswers[] = [
                    'question' => $question,
                    'studentAnswer' => $response['response']
                ];
            }
        }

        $completedDate = \DateTime::createFromFormat('d/m/Y H:i:s', $latestResponse['completed']);
        $formattedDate = $completedDate->format('jS F Y g:i A');

        $output = "{$student['firstName']} {$student['lastName']} recently completed {$assessment['name']} assessment on {$formattedDate}\n";
        $output .= "He got {$totalCorrect} questions right out of {$totalQuestions}. Feedback for wrong answers given below\n\n";

        foreach ($wrongAnswers as $wrong) {
            $question = $wrong['question'];
            $studentAnswerId = $wrong['studentAnswer'];
            $correctAnswerId = $question['config']['key'];

            $studentOption = null;
            $correctOption = null;
            
            foreach ($question['config']['options'] as $option) {
                if ($option['id'] === $studentAnswerId) {
                    $studentOption = $option;
                }
                if ($option['id'] === $correctAnswerId) {
                    $correctOption = $option;
                }
            }

            $output .= "Question: {$question['stem']}\n";
            $output .= "Your answer: {$studentOption['label']} with value {$studentOption['value']}\n";
            $output .= "Right answer: {$correctOption['label']} with value {$correctOption['value']}\n";
            $output .= "Hint: {$question['config']['hint']}\n\n";
        }

        return $output;
    }
}