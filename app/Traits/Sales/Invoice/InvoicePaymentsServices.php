<?php

namespace App\Traits\Sales\Invoice;

use App\Models\InvoicePayment;

trait InvoicePaymentsServices
{
    /**
     * Create a new record of payment
     *
     * @param  integer $accountId
     * @param  integer $currencyId
     * @param  integer $paymentMethodId
     * @param  string $date
     * @param  float $amount
     * @param  string|null $description
     * @param  string|null $reference
     * @return InvoicePayment
     */
    public function payment (int $accountId, int $currencyId, int $paymentMethodId, string $date, float $amount, ?string $description, ?string $reference): InvoicePayment
    {
        return InvoicePayment::create([
            'account_id' => $accountId,
            'currency_id' => $currencyId,
            'payment_method_id' => $paymentMethodId,
            'date' => $date,
            'amount' => $amount,
            'description' => $description,
            'reference' => $reference
        ]);
    }
}