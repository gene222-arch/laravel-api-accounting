<?php

namespace App\Imports\Purchases;

use App\Models\Item;
use App\Models\Account;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\IncomeCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PaymentImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'paid_at' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'account' => ['required', 'string', 'exists:accounts,name'],
            'vendor' => ['required', 'string', 'exists:vendors,name'],
            'category' => ['required', 'string', 'exists:expense_categories,name'],
            'currency' => ['required', 'string', 'exists:currencies,code'],
            'payment_method' => ['required', 'string', 'exists:payment_methods,name'],
            'reference' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
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
            'payment_method' => 'payment method',
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
            'id',
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
            'date' => $row['paid_at'],
            'amount' => $row['amount'],
            'description' => $row['description'],
            'reference' => $row['reference'],
            'account_id' => Account::where('name', $row['account'])->first()->id,
            'vendor_id' => Customer::where('name', $row['vendor'])->first()->id,
            'expense_category_id' => IncomeCategory::where('name', $row['category'])->first()->id,
            'payment_method_id' => PaymentMethod::where('name', $row['payment_method'])->first()->id,
            'currency_id' => Currency::where('code', $row['currency'])->first()->id,
        ]);
    }
}
