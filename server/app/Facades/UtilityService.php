<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UtilityService extends Facade
{
    protected static function getFacadeAccessor() {
        return 'UtilityService';
    }
}