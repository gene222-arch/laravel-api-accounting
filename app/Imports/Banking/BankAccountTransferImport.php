<?php

namespace App\Imports\Banking;

use App\Models\Account;
use App\Models\Item;
use App\Models\Category;
use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BankAccountTransferImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'from_account' => ['required', 'string', 'exists:accounts,name'],
            'to_account' => ['required', 'string', 'exists:accounts,name'],
            'payment_method' => ['required', 'string', 'exists:payment_methods,name'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transferred_at' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'reference' => ['nullable', 'string']
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'from_account' => 'from account',
            'to_account' => 'to account',
            'payment_method' => 'payment method',
            'transferred_at' => 'date of transfer'
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
            'from_account_id' => Account::where('name', $row['from_account'])->first()->id,
            'to_account_id' => Account::where('name', $row['to_account'])->first()->id,
            'payment_method_id' => PaymentMethod::where('name', $row['payment_method'])->first()->id,
            'amount' => $row['amount'],
            'transferred_at' => $row['transferred_at'],
            'description' => $row['description'],
            'reference' => $row['reference']
        ]);
    }
}
