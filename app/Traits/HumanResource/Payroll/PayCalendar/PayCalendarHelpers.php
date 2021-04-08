<?php

namespace App\Traits\HumanResource\Payroll\PayCalendar;

trait PayCalendarHelpers
{
    protected static function getPayDayMode (string $payCalendarType)
    {
        $payModes = [
            'Weekly' => 'Sunday',
            'Bi-weekly' => 'Sunday',
            'Semi-monthly' => '15th and 30th day',
            'Monthly' => '30th day'
        ];

        return $payModes[$payCalendarType];
    }
}