<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DataLoader;
use App\Services\Reports\DiagnosticReport;

class DiagnosticReportTest extends TestCase
{
    private DiagnosticReport $report;

    // Set up the DiagnosticReport instance before each test
    protected function setUp(): void
    {
        parent::setUp();
        $dataLoader = new DataLoader();
        $this->report = new DiagnosticReport($dataLoader);
    }

    // Basic tests to ensure report generation works as expected
    public function test_generates_report_with_student_name()
    {
        $output = $this->report->generate('student1');
        
        $this->assertStringContainsString('Tony Stark', $output);
    }

    // Test to ensure assessment name appears in the report
    public function test_report_includes_assessment_name()
    {
        $output = $this->report->generate('student1');
        
        $this->assertStringContainsString('Numeracy', $output);
    }

    // Test to ensure correct question counts appear in the report
    public function test_report_includes_strand_breakdown()
    {
        $output = $this->report->generate('student1');
        
        $this->assertStringContainsString('Number and Algebra', $output);
        $this->assertStringContainsString('Measurement and Geometry', $output);
        $this->assertStringContainsString('Statistics and Probability', $output);
    }

    // Test to ensure exception is thrown for invalid student ID
    public function test_throws_exception_for_invalid_student()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Student not found');
        
        $this->report->generate('invalid_student');
    }
}