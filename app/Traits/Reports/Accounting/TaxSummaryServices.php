<?php

namespace App\Traits\Reports\Accounting;

use App\Models\TaxSummary;
use Illuminate\Support\Facades\DB;

trait TaxSummaryServices
{
        
    /**
     * createTaxSummary
     *
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string $type
     * @param  integer $tax_id
     * @param  float $amount
     * @return App\Models\TaxSummary
     */
    public function createTaxSummary(string $model_type, int $model_id, string $type, int $tax_id, float $amount): TaxSummary
    {
        return TaxSummary::create([
            'model_type' => $model_type,
            'model_id' => $model_id,
            'type' => $type,
            'tax_id' => $tax_id,
            'amount' => $amount
        ]);
    }

    /**
     * Create multiple tax summaries
     *
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string $type
     * @param  array $taxSummaryDetails
     * @return bool
     */
    public function createManyTaxSummary(string $model_type, int $model_id, string $type, array $taxSummaryDetails): bool
    {
        $taxSummaryDetails = array_map(function (array $taxSummary) use ($model_type, $model_id, $type) 
        {
            if ($taxSummary['tax_id'])
            {
                return [
                    'model_type' => $model_type,
                    'model_id' => $model_id,
                    'type' => $type,
                    'tax_id' => $taxSummary['tax_id'],
                    'amount' => $taxSummary['tax']
                ];
            }
        }, $taxSummaryDetails);

        return TaxSummary::insert($taxSummaryDetails);
    }
        
    /**
     * updateTaxSummaryByModelId
     *
     * @param  \App\Models\TaxSummary $taxSummary
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string $type
     * @param  integer $tax_id
     * @param  float $amount
     * @return bool
     */
    public function updateTaxSummaryByModelId(TaxSummary $taxSummary, string $model_type, int $model_id, string $type, int $tax_id, float $amount): bool
    {
        return $taxSummary->update([
                'model_type' => $model_type,
                'model_id' => $model_id,
                'type' => $type,
                'tax_id' => $tax_id,
                'amount' => $amount
            ]);
    }

    /**
     * updateTaxSummaryByModelId
     *
     * @param  string $model_type
     * @param  integer $model_id
     * @param  string $type
     * @param  array $taxSummaryDetails
     * @return mixed
     */
    public function updateManyTaxSummary(string $model_type, int $model_id, string $type, array $taxSummaryDetails): mixed
    {
        try {
            DB::transaction(function () use ($model_type, $model_id, $type, $taxSummaryDetails)
            {
                TaxSummary::where('model_id', $model_id)->delete();

                $this->createManyTaxSummary(
                    $model_type, 
                    $model_id, 
                    $type,
                    $taxSummaryDetails
                );
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Delete multiple records of tax summaries via model id and model type
     *
     * @param  string $modelType
     * @param  array $modelIds
     * @return bool
     */
    public function deleteManyTaxSummaries (string $modelType, ...$modelIds): bool
    {
        return TaxSummary::where('model_type', $modelType)->whereIn('model_id', $modelIds)->delete();
    }
}