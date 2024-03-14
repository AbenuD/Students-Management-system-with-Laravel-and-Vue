<?php

namespace App\Imports;

use App\Models\Course;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class CoursesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        Log::info('Processing row: ' . json_encode($row));
     
        if (!isset($row['name']) || !isset($row['code']) || !isset($row['chr'])) {
            Log::error('Invalid row: ' . json_encode($row));
            return null; // Skip this row
        }

        $courseName = $row['name'];
        $courseCode = $row['code'];
        $creditHour = $row['chr'];

        if (!empty($courseCode) && !empty($courseName) && !empty($creditHour)) {
            $course = Course::updateOrCreate(
                ['courseCode' => $courseCode],
                ['courseName' => $courseName, 'creditHour' => $creditHour]
            );

            return $course;
        } else {
            Log::error('Empty courseName or courseCode: ' . json_encode($row));
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'chr' => 'required|numeric',
            // Add more validation rules for other fields
        ];
    }

    public function batchSize(): int
    {
        return 100; // Set the number of rows that should be validated and inserted at a time
    }

    public function chunkSize(): int
    {
        return 1000; // Set the number of rows that should be read into memory at a time
    }
}
