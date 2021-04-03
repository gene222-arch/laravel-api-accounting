<?php

namespace App\Traits\Sales\Payment;

use App\Models\Model;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

trait PaymentsServices
{
    /**
     * Create a new record of payment
     *
     * @param  string $modelType
     * @param  integer $modelId
     * @param  string $date
     * @param  float $amount
     * @param  string $account
     * @param  string $currency
     * @param  string|null $description
     * @param  string $payment_method
     * @param  string|null $reference
     * @return Payment
     */
    public function payment (string $modelType, int $modelId, string $date, float $amount, string $account, string $currency, ?string $description, string $payment_method, ?string $reference): Payment
    {
        return Payment::create([
            'model_type' => $modelType,
            'model_id' => $modelId,
            'date' => $date,
            'amount' => $amount,
            'account' => $account,
            'currency' => $currency,
            'description' => $description,
            'payment_method' => $payment_method,
            'reference' => $reference
        ]);
    }
}