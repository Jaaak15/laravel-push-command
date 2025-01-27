<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::middleware('api')->get( '/gh/pull-command/{code}', function ( $code ) {    
   
    Artisan::call('gh:pull', [
        'code' => $code
    ]);

    return response()->json([
        Artisan::output()
    ]);;

})->name('gh.server.pull');