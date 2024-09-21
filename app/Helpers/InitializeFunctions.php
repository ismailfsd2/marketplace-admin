<?php

use Illuminate\Support\Facades\Artisan;

function runMigrations()
{
    Artisan::call('migrate');
    
}
