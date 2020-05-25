<?php

namespace App\Exceptions\Images;

use Exception;

class NoFileSpecifiedToUpload extends Exception
{
    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'image' => [],
            'error' => 'Please give a file to upload.',
        ], 500);
    }
}