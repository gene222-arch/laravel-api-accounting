<?php

namespace App\Traits\Settings\Contribution;

use App\Models\Contribution;
use Illuminate\Database\Eloquent\Collection;

trait ContributionsServices
{
    
    /**
     * Get latest records of contributions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllContributions (): Collection
    {
        return Contribution::latest()
            ->get([
                'id', 
                ...(new Contribution())->getFillable()
            ]);
    }
    
    /**
     * Get a record of contribution via id
     *
     * @param  int $id
     * @return Contribution|null
     */
    public function getContributionById (int $id): Contribution|null
    {
        return Contribution::select(
            'id',
            ...(new Contribution())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    
    /**
     * Create a new record of contribution
     *
     * @param  string $name
     * @param  float $rate
     * @param  bool $enabled
     * @return Contribution
     */
    public function createContribution (string $name, float $rate, bool $enabled): Contribution
    {
        return Contribution::create([
            'name' => $name,
            'rate' => $rate,
            'enabled' => $enabled
        ]);
    }

    /**
     * Update an existing record of contribution
     *
     * @param  integer $id
     * @param  string $name
     * @param  float $rate
     * @param  bool $enabled
     * @return Contribution
     */
    public function updateContribution (int $id, string $name, float $rate, bool $enabled): bool
    {
        return Contribution::where('id', $id)
            ->update([
                'name' => $name,
                'rate' => $rate,
                'enabled' => $enabled
            ]);
    }

    /**
     * Delete one or multiple records of contributions
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteContributions (array $ids): bool
    {
        return Contribution::whereIn('id', $ids)->delete();
    }
}