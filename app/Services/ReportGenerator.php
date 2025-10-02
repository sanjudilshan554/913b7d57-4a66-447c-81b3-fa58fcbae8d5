<?php

namespace App\Services;

use App\Services\Reports\DiagnosticReport;
use App\Services\Reports\ProgressReport;
use App\Services\Reports\FeedbackReport;

class ReportGenerator
{
    public function __construct(
        private DataLoader $dataLoader
    ) {}

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