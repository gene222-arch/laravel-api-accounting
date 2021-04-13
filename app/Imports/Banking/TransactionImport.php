<?php

namespace App\Imports\Banking;

use App\Models\Account;
use App\Models\Item;
use App\Models\Currency;
use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TransactionImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:transactions,id'],
            'type' => ['required', 'string', 'in:Income,Expense'],
            'paid_at' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'exists:currencies,code'],
            'account' => ['required', 'string', 'exists:accounts,name'],
            'number' => ['nullable', 'string'],
            'contact' => ['required', 'string'],
            'category' => ['required', 'string', 'exists:categories,name'],
            'description' => ['nullable', 'string'],
            'payment_method' => ['required', 'string', 'exists:payment_methods,name'],
            'reference' => ['nullable', 'string']
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'paid_at' => 'paid at',
            'payment_method' => 'payment method',
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
        return new Item([
            'id' => $row['id'],
            'type' => $row['type'],
            'amount' => $row['amount'],
            'currency_id' => Currency::where('name', $row['currency'])->first()->id,
            'account_id' => Account::where('name', $row['account'])->first()->id,
            'number' => $row['number'],
            'contact' => $row['contact'],
            'category' => $row['category'],
            'description' => $row['description'],
            'payment_method_id' => PaymentMethod::where('name', $row['payment_method'])->first()->id,
            'reference' => $row['reference'],
            'created_at' => $row['paid_at'],
        ]);
    }
}
