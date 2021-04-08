<?php

namespace App\Traits\HumanResource\Payroll\PayCalendar;

use App\Models\PayCalendar;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait PayCalendarsServices
{
    use PayCalendarHelpers;
    
    /**
     * Get latest records of pay calendars
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllPayCalendars (): Collection
    {
        return PayCalendar::with([
            'employees' => fn($q) => $q->selectRaw('
                employees.id,
                employees.first_name,
                employees.last_name,
                employees.email
            ')
        ])
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of pay calendar via id
     *
     * @param  int $id
     * @return PayCalendar|null
     */
    public function getPayCalendarById (int $id): PayCalendar|null
    {
        return PayCalendar::where('id', $id)
            ->with([
                'employees' => fn($q) => $q->selectRaw('
                    employees.id,
                    employees.first_name,
                    employees.last_name,
                    employees.email
                ')
            ])
            ->first();
    }
    
    /**
     * Create a new record of pay calendar
     *
     * @param  string $name
     * @param  string $type
     * @param  array $employeeIds
     * @return mixed
     */
    public function createPayCalendar (string $name, string $type, array $employeeIds): mixed
    {
        try {
            DB::transaction(function () use ($name, $type, $employeeIds)
            {
                $payCalendar = PayCalendar::create([
                    'name' => $name,
                    'type' => $type,
                    'pay_day_mode' => self::getPayDayMode($type)
                ]);

                $payCalendar->employees()->attach($employeeIds);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }
    
    /**
     * Update an existing record of pay calendar
     *
     * @param  integer $id
     * @param  string $name
     * @param  string $type
     * @param  array $employeeIds
     * @return mixed
     */
    public function updatePayCalendar (int $id, string $name, string $type, array $employeeIds): mixed
    {
        try {
            DB::transaction(function () use ($id, $name, $type, $employeeIds)
            {
                $payCalendar = PayCalendar::find($id);

                $payCalendar->update([
                    'name' => $name,
                    'type' => $type,
                    'pay_day_mode' => self::getPayDayMode($type)
                ]);

                $payCalendar->employees()->sync($employeeIds);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of pay calendars
     *
     * @param  array $ids
     * @return boolean
     */
    public function deletePayCalendars (array $ids): bool
    {
        return PayCalendar::whereIn('id', $ids)->delete();
    }
}