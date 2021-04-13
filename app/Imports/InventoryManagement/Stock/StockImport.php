<?php

namespace App\Imports\InventoryManagement\Stock;

use App\Models\Stock;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StockImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'in_stock' => ['required', 'min:0'],
            'bad_stock' =>  ['required', 'min:0'],
            'stock_in' =>  ['required', 'min:0'],
            'stock_out' =>  ['required', 'min:0'],
            'incoming_stock' =>  ['required', 'min:0'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'in_stock' => 'in stock',
            'bad_stock' => 'bad stock',
            'stock_in' => 'stock in',
            'stock_out' => 'stock out',
            'incoming_stock' => 'incoming stock'
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
            'id'
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
        return new Stock([
            'item_id' => $row['id'],
            'in_stock' => $row['in_stock'],
            'incoming_stock' => $row['incoming_stock'],
            'bad_stock' => $row['bad_stock'],
            'stock_in' => $row['stock_in'],
            'stock_out' => $row['stock_out']
        ]);
    }
}
