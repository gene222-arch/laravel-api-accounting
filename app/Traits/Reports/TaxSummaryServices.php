<?php

namespace App\Traits\Reports;

use App\Models\TaxSummary;

trait TaxSummaryServices
{
        
    /**
     * createTaxSummary
     *
     * @param  string $model_type
     * @param  integer $model_id
     * @param  integer $tax_id
     * @param  float $amount
     * @return App\Models\TaxSummary
     */
    public function createTaxSummary(string $model_type, int $model_id, int $tax_id, float $amount): TaxSummary
    {
        return TaxSummary::create([
            'model_type' => $model_type,
            'model_id' => $model_id,
            'tax_id' => $tax_id,
            'amount' => $amount
        ]);
    }
        
    /**
     * updateTaxSummaryByModelId
     *
     * @param  \App\Models\TaxSummary $taxSummary
     * @param  string $model_type
     * @param  integer $model_id
     * @param  integer $tax_id
     * @param  float $amount
     * @return bool
     */
    public function updateTaxSummaryByModelId(TaxSummary $taxSummary, string $model_type, int $model_id, int $tax_id, float $amount): bool
    {
        return $taxSummary->update([
                'model_type' => $model_type,
                'model_id' => $model_id,
                'tax_id' => $tax_id,
                'amount' => $amount
            ]);
    }
}