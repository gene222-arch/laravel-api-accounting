<?php

namespace App\Imports\Sales;

use App\Models\Item;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\IncomeCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InvoiceImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'customer' => ['required', 'string', 'exists:customers,name'],
            'invoice_number' => ['required', 'string', 'unique:invoices,invoice_number'],
            'order_number' => ['required', 'integer', 'unique:invoices,order_no'],
            'date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Draft,Partially Paid,Paid'],
            'category' => ['required', 'string', 'exists:income_categories,name']
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'invoice_number' => 'invoice number',
            'order_number' => 'order number',
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
            'invoice_number'
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
            'customer_id' => Customer::where('name', $row['customer'])->first()->id,
            'currency_id' => Currency::where('code', $row['currency'])->first()->id,
            'income_category_id' => IncomeCategory::where('name', $row['category'])->first()->id,
            'invoice_number' => $row['invoice_number'],
            'order_no' => $row['order_number'],
            'date' => $row['date'],
            'due_date' => $row['due_date'],
            'status' => $row['status']
        ]);
    }
}
