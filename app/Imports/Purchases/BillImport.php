<?php

namespace App\Imports\Purchases;

use App\Models\Item;
use App\Models\Category;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BillImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'vendor' => ['required', 'string', 'exists:vendors,name'],
            'bill_number' => ['nullable', 'string', 'unique:bills,bill_number'],
            'order_no' => ['required', 'integer', 'unique:bills,order_no'],
            'date' => ['required', 'string'],
            'due_date' => ['required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'bill_number' => 'bill number',
            'due_date' => 'due date'
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
            'bill_number',
            'order_no'
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
        return new Item([
            'id' => $row['id'],
            'vendor_id' => Vendor::where('name', $row['vendor'])->first()->id,
            'bill_number' => $row['bill_number'],
            'order_no' => $row['order_no'],
            'date' => $row['date'],
            'due_date' => $row['due_date']
        ]);
    }
}
