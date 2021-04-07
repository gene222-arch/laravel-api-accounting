<?php

namespace App\Traits\Settings\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

trait CompanyServices
{

    /**
     * Get a record of company via id
     *
     * @param  int $id
     * @return Company|null
     */
    public function getCompanyById (int $id): Company|null
    {
        return Company::select(
            'id',
            ...(new Company())->getFillable()
        )
            ->where('id', $id)
            ->first();
    }
    
    /**
     * Create a new record of company 
     *
     * @param  string $name
     * @param  string $email
     * @param  string $taxNumber
     * @param  string $phone
     * @param  string|null $address
     * @param  string|null $logo
     * @return Company
     */
    public function createCompany (string $name, string $email, string $taxNumber, string $phone, ?string $address, ?string $logo): Company
    {
        return Company::create([
            'name' => $name,
            'email' => $email,
            'tax_number' => $taxNumber,
            'phone' => $phone,
            'address' => $address,
            'logo' => $logo
        ]);
    }
    
    /**
     * Update an existing record of company
     *
     * @param  string $name
     * @param  string $email
     * @param  string $taxNumber
     * @param  string $phone
     * @param  string|null $address
     * @param  string|null $logo
     * @return Company
     */
    public function updateCompany (int $id, string $name, string $email, string $taxNumber, string $phone, ?string $address, ?string $logo): bool
    {
        return Company::where('id', $id)
            ->update([
                'name' => $name,
                'email' => $email,
                'tax_number' => $taxNumber,
                'phone' => $phone,
                'address' => $address,
                'logo' => $logo
            ]);
    }
}