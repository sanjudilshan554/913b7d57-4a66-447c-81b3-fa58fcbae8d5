<?php

namespace App\Contracts;

/**
 * ReportInterface
 */
interface ReportInterface
{
    public function generate(string $studentId): string;
}