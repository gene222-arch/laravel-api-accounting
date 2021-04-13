<?php

namespace App\Imports\Sales;

use App\Models\Account;
use App\Models\Revenue;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\IncomeCategory;
use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class RevenueImport implements ToModel, WithHeadingRow, WithUpserts, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function rules(): array
    {
        return [
            'paid_at' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'recurring' => ['required', 'string', 'in:No,Daily,Weekly,Monthly,Yearly'],
            'reference' => ['nullable', 'string'],
            'account' => ['required', 'string', 'exists:accounts,name'],
            'customer' => ['required', 'string', 'exists:customers,name'],
            'income_category' => ['required', 'string', 'exists:income_categories,name'],
            'payment_method' => ['required', 'string', 'exists:payment_methods,name'],
            'currency' => ['required', 'string', 'exists:currencies,code'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'income_category' => 'income category',
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
        return new Revenue([
            'id' => $row['id'],
            'date' => $row['paid_at'],
            'amount' => $row['amount'],
            'description' => $row['description'],
            'reference' => $row['reference'],
            'account_id' => Account::where('name', $row['account'])->first()->id,
            'customer_id' => Customer::where('name', $row['customer'])->first()->id,
            'income_category_id' => IncomeCategory::where('name', $row['income_category'])->first()->id,
            'payment_method_id' => PaymentMethod::where('name', $row['payment_method'])->first()->id,
            'currency_id' => Currency::where('code', $row['currency'])->first()->id,
        ]);
    }
}
