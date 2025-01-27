<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get( '/gh/pull-command/{code}', function () {
    
    \Artisan::call('cache:clear');

    dd("Cache is cleared");

});