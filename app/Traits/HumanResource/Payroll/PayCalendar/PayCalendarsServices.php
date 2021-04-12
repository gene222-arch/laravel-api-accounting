<?php

namespace App\Traits\HumanResource\Payroll\PayCalendar;

use App\Models\PayCalendar;
use Illuminate\Support\Facades\DB;

trait PayCalendarsServices
{
    use PayCalendarHelpers;
    
    /**
     * Create a new record of pay calendar
     *
     * @param  string $name
     * @param  string $type
     * @param  array $employee_ids
     * @return mixed
     */
    public function createPayCalendar (string $name, string $type, array $employee_ids): mixed
    {
        try {
            DB::transaction(function () use ($name, $type, $employee_ids)
            {
                $payCalendar = PayCalendar::create([
                    'name' => $name,
                    'type' => $type,
                    'pay_day_mode' => self::getPayDayMode($type)
                ]);

                $payCalendar->employees()->attach($employee_ids);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of pay calendar
     *
     * @param  PayCalendar $payCalendar
     * @param  string $name
     * @param  string $type
     * @param  array $employee_ids
     * @return mixed
     */
    public function updatePayCalendar (PayCalendar $payCalendar, string $name, string $type, array $employee_ids): mixed
    {
        try {
            DB::transaction(function () use ($payCalendar, $name, $type, $employee_ids)
            {
                $payCalendar->update([
                    'name' => $name,
                    'type' => $type,
                    'pay_day_mode' => self::getPayDayMode($type)
                ]);

                $payCalendar->employees()->sync($employee_ids);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

}