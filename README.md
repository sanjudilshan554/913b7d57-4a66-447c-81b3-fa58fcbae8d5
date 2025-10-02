# Assessment Reporting System

[![Run Tests (Docker)](https://github.com/sanjudilshan554/913b7d57-4a66-447c-81b3-fa58fcbae8d5/actions/workflows/test.yml/badge.svg)](https://github.com/sanjudilshan554/913b7d57-4a66-447c-81b3-fa58fcbae8d5/actions/workflows/test.yml)

A Laravel-based CLI application that generates three types of reports from student assessment data: Diagnostic, Progress, and Feedback reports.

## Overview

This system processes student assessment responses and generates insightful reports to help students understand their performance, track progress over time, and receive targeted feedback for improvement.

## Features

### Three Report Types

1. **Diagnostic Report**: Performance breakdown by learning strand
   - Shows total questions and correct answers per strand
   - Calculates accuracy percentage for each strand
   - Identifies strengths and areas for improvement

2. **Progress Report**: Improvement tracking across multiple attempts
   - Compares performance between recent assessments
   - Shows improvement or decline in each strand
   - Highlights overall learning trajectory

3. **Feedback Report**: Detailed feedback on incorrect answers
   - Provides question-specific feedback
   - Includes hints for incorrect responses
   - Helps students understand their mistakes

## Prerequisites

### Option 1: Using Docker (Recommended)
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Option 2: Local Installation
- PHP 8.2 or higher
- [Composer](https://getcomposer.org/)
- Laravel 11.x

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/sanjudilshan554/913b7d57-4a66-447c-81b3-fa58fcbae8d5.git
cd 913b7d57-4a66-447c-81b3-fa58fcbae8d5
```

### 2. Setup with Docker (Recommended)

#### Build and Start the Container
```bash
docker compose build
docker compose up -d
```

#### Install Dependencies
```bash
docker compose run --rm app composer install
```

#### Setup Environment
```bash
docker compose run --rm app cp .env.example .env
docker compose run --rm app php artisan key:generate
```

#### Fix Permissions
```bash
docker compose run --rm app chmod -R 777 storage bootstrap/cache
```

#### Access the Container
```bash
docker compose run --rm app bash
```

### 3. Setup without Docker (Local)

#### Install Dependencies
```bash
composer install
```

#### Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

#### Fix Permissions
```bash
chmod -R 777 storage bootstrap/cache
```

## Usage

### Running Reports

All commands should be executed inside the Docker container or in your local environment.

### Docker Commands

#### Enter Container Shell
```bash
docker compose run --rm app bash
```

#### Run Commands Inside Container
```bash
docker compose run --rm app php artisan <command>
```

#### Stop Containers
```bash
docker compose down
```

#### View Container Logs
```bash
docker compose logs -f app
```

## Testing

This project includes comprehensive test coverage for all report types.

### Run Tests with Docker
```bash
docker compose run --rm app php artisan test
```

### Run Tests Locally
```bash
php artisan test
```

### Run Specific Test Suite
```bash
php artisan test --testsuite=Feature
```

### Run Tests with Coverage
```bash
php artisan test --coverage
```

## CI/CD

This project uses GitHub Actions for continuous integration. The workflow automatically:

- Builds Docker containers
- Installs dependencies
- Sets up the environment
- Runs all tests

The workflow is triggered on:
- Pushes to the `main` branch
- Pull requests to the `main` branch

See [`.github/workflows/test.yml`](.github/workflows/test.yml) for configuration details.

## Project Structure

```
.
├── app/
│   ├── Console/
│   │   └── Commands/          # Artisan commands for reports
│   ├── Services/              # Business logic for report generation
│   └── Models/                # Data models
├── tests/
│   ├── Feature/               # Feature tests for commands
│   └── Unit/                  # Unit tests for services
├── storage/
│   └── app/
│       └── data/              # JSON data files
├── docker-compose.yml         # Docker Compose configuration
├── Dockerfile                 # Docker container definition
└── .github/
    └── workflows/
        └── test.yml           # CI/CD workflow
```

## Data Files

The system expects JSON data files in the `storage/app/data/` directory:

- `questions.json` - Question definitions with strands
- `student-responses.json` - Student assessment responses
- `assessments.json` - Assessment metadata

## Docker Configuration

### Dockerfile
- Base image: `php:8.2-cli`
- Includes Composer
- Installs Git and unzip for dependency management
- Working directory: `/app`

### Docker Compose
- Service name: `app`
- Hot reload enabled through volume mounting
- Interactive terminal support
- Vendor directory optimized for performance

## Troubleshooting

### Permission Issues
If you encounter permission errors:
```bash
docker compose run --rm app chmod -R 777 storage bootstrap/cache
```

### Container Not Starting
Check if port conflicts exist:
```bash
docker compose down
docker compose up -d
```

### Composer Dependencies
Rebuild dependencies:
```bash
docker compose run --rm app composer install --no-cache
```

### Clear Laravel Cache
```bash
docker compose run --rm app php artisan cache:clear
docker compose run --rm app php artisan config:clear
```

## Requirements

- Docker Engine 20.10+
- Docker Compose 2.0+
- Minimum 2GB RAM for Docker
- 500MB disk space

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For issues and questions:
- Create an issue in the [GitHub repository](https://github.com/sanjudilshan554/913b7d57-4a66-447c-81b3-fa58fcbae8d5/issues)
- Check existing issues for solutions

## Acknowledgments

- Built with [Laravel 11](https://laravel.com)
- Containerized with [Docker](https://www.docker.com)
- CI/CD powered by [GitHub Actions](https://github.com/features/actions)