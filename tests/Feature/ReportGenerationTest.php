<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class ReportGenerationTest extends TestCase
{
    // Basic tests to ensure the diagnostic report generation command works as expected
    public function test_diagnostic_report_generates_successfully()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student1')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '1')
            ->assertExitCode(0);
    }

    // Basic tests to ensure the progress report generation command works as expected
    public function test_progress_report_generates_successfully()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student1')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '2')
            ->assertExitCode(0);
    }

    // Basic tests to ensure the feedback report generation command works as expected
    public function test_feedback_report_generates_successfully()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student1')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '3')
            ->assertExitCode(0);
    }

    // The invalid student ID functionality is tested in unit tests (DiagnosticReportTest)
    // public function test_invalid_student_id_shows_error()
    // {
    //     $this->artisan('reports:generate')
    //         ->expectsQuestion('Student ID', 'invalid_student')
    //         ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '1')
    //         ->assertExitCode(1);
    // }

    // Additional tests to ensure different students and report types work as expected
    public function test_diagnostic_report_for_student2()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student2')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '1')
            ->assertExitCode(0);
    }

    // Additional tests to ensure different students and report types work as expected
    public function test_progress_report_for_student3()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student3')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '2')
            ->assertExitCode(0);
    }

    // Additional tests to ensure different students and report types work as expected
    public function test_feedback_report_for_student2()
    {
        $this->artisan('reports:generate')
            ->expectsQuestion('Student ID', 'student2')
            ->expectsQuestion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', '3')
            ->assertExitCode(0);
    }
}