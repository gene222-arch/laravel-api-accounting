<?php

use Illuminate\Support\Facades\DB;

    if (!function_exists('setSqlModeEmpty'))
    {
        function setSqlModeEmpty()
        {
            DB::statement('SET SQL_MODE="" ');
        }
    }