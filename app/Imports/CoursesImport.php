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
     

        if (!empty($row['name']) && !empty($row['code']) && !empty($row['chr'])) {
            return new Course([
                'courseName' => $row['name'],
                'courseCode' => $row['code'],
                'creditHour' => $row['chr'], 
            ]);
        }
        Log::error('Empty courseName or courseCode');
        return null;
    }

    public function rules(): array
    {
        return [
            'courseName' => 'string|max:255',
            'courseCode' => 'string|max:255',
            'creditHour' => 'numeric',
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

