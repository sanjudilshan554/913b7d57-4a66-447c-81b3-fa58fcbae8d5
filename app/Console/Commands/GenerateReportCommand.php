<?php

namespace App\Console\Commands;

use App\Services\ReportGenerator;
use Illuminate\Console\Command;

class GenerateReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate student assessment reports';

    /**
     * Execute the console command.
     */
    public function handle(ReportGenerator $reportGenerator)
    {
        $this->info('Please enter the following');
        $this->newLine();

        while (true) {
            $studentId = $this->ask('Student ID');

            $reportType = $this->ask('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)');

            $type = match ($reportType) {
                '1' => 'diagnostic',
                '2' => 'progress',
                '3' => 'feedback',
                default => null
            };

            if (!$type) {
                $this->error('Invalid report type. Please enter 1, 2, or 3.');
                continue;
            }

            try {
                $this->newLine();
                $report = $reportGenerator->generate($studentId, $type);
                $this->info($report);
                return 0;
            } catch (\Exception $e) {
                $this->error('Error: ' . $e->getMessage());
                if (str_contains(strtolower($e->getMessage()), 'student')) {
                    $this->info('Please try again with a valid Student ID.');
                    continue;
                }
                return 1;
            }
        }
        return 0;
    }
}
