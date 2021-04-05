<?php

namespace App\Models;

use App\Models\Revenue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Settings\IncomeCategory\IncomeCategoriesServices;

class IncomeCategory extends Model
{
    /** Libraries or Built-in */
    use HasFactory;

    /** Custom */
    use IncomeCategoriesServices;

    protected $fillable = [
        'name',
        'hex_code'
    ];  

    /**
     * Define a one-to-many relationship with Revenue Class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function revenues(): HasMany
    {
        return $this->hasMany(Revenue::class);
    }
}
