<?php

namespace App\Services;

use App\Services\Reports\DiagnosticReport;
use App\Services\Reports\ProgressReport;
use App\Services\Reports\FeedbackReport;

class ReportGenerator
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
     * @param string $type [explicite description]
     *
     * @return string
     */
    public function generate(string $studentId, string $type): string
    {
        $report = match($type) {
            'diagnostic' => new DiagnosticReport($this->dataLoader),
            'progress' => new ProgressReport($this->dataLoader),
            'feedback' => new FeedbackReport($this->dataLoader),
            default => throw new \InvalidArgumentException("Invalid report type: {$type}")
        };

        return $report->generate($studentId);
    }
}