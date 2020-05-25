<?php

namespace App\Exceptions\Images;

use Exception;
use Illuminate\Support\Facades\Request;

class NoApiTokenSpecifiedToValidate extends Exception
{
    public function report()
    {
        //
    }

    public function render(Request $request)
    {
        return response()->json([
            'success' => false,
            'image' => [],
            'error' => 'Please give a api key to validate.',
        ], 500);
    }
}