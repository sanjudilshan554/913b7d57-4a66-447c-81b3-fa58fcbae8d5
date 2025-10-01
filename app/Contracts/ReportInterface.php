<?php

namespace App\Contracts;

interface ReportInterface
{
    public function generate(string $studentId): string;
}