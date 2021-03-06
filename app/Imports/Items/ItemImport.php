<?php

namespace App\Imports\Items;

use App\Models\Item;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ItemImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer', 'exists:items,id'],
            '*.sku' => ['required', 'alpha_num', 'min:1', 'max:13', 'unique:items,sku'],
            '*.barcode' => ['required', 'alpha_num', 'min:1', 'max:13', 'unique:items,barcode'],
            '*.name' => ['required', 'string', 'unique:items,name'],
            '*.category' => ['required', 'exists:categories,name'],
            '*.sold_by' => ['required', 'in:each,weight'],
            '*.price' => ['numeric', 'nullable'],
            '*.cost' => ['required', 'numeric'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            '*.id' => 'item',
            '*.name' => 'item name',
            '*.sold_by' => 'sold by',
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
            '*.category.exists' => 'The :attribute does not exist.',
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
            'sku',
            'barcode'
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
            'sku' => $row['sku'],
            'barcode' => $row['barcode'],
            'name' => $row['name'],
            'image' => 'http://127.0.0.1:8000/storage/images/Products/product_default_img_1614450024.svg',
            'category' => Category::where('name', '=', $row['category'])->first()->id,
            'sold_by' => $row['sold_by'],
            'price' => $row['price'],
            'cost' => $row['cost'],
        ]);
    }
}
