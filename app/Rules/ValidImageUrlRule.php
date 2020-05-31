<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidImageUrlRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $r = $client->request('GET', $value);
        } catch (\Exception $e) {
            return false;
        }

        if ($r->getStatusCode() != 200) {
            return false;
        }

        if ($r->getStatusCode() == 200) {
            $c = $r->getHeaderLine('content-type');
            if ($c == 'image/png' || $c == 'image/jpeg' || $c == 'image/jpg' || $c == 'image/svg' || $c == 'image/gif'
            || $c == 'image/bmp' || $c == 'image/tiff') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your image URL is not valid.';
    }
}
