<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidImageUrlRule implements Rule
{
    protected $newValue;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($newValue)
    {
        $this->newValue = $newValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (filter_var($this->newValue, FILTER_VALIDATE_URL) === false) {
            return false;
        } else {
            $client = new \GuzzleHttp\Client();

            try {
                $r = $client->request('GET', $this->newValue);
            } catch (\Exception $e) {
                return false;
            }

            if ($r->getStatusCode() != 200) {
                return false;
            }

            if ($r->getStatusCode() == 200) {
                $c = $r->getHeaderLine('content-type');
                if ($c == 'image/png' || $c == 'image/jpeg' || $c == 'image/jpg' || $c == 'image/svg' || $c == 'image/gif') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
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
