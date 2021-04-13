<?php

namespace App\Imports\Purchases;

use App\Models\Vendor;
use App\Models\Category;
use App\Models\Currency;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class VendorImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:currencies,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:vendors,email'],
            'tax_number' => ['required', 'string', 'min:5', 'max:5', 'unique:vendors,tax_number'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:vendors,phone'],
            'website' => ['nullable', 'website'],
            'reference' => ['nullable', 'string'],
            'enabled' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'tax_number' => 'tax number'
        ];
    }

    /**
     * Custom validation message
     * 
     * @return array
     */
    public function customValidationMessages()
    {
        return [
        ];
    }
    
    /**
     * Unique foreign keys
     *
     * @return array
     */
    public function uniqueBy()
    {
        return [
            'email'
        ];
    }
    
    /**
     * Batch size
     *
     * @return int
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Vendor([
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'tax_number' => $row['tax_number'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'website' => $row['website'],
            'currency_id' => Currency::where('code', $row['currency_code'])->first()->id,
            'reference' => $row['reference']
        ]);
    }
}
