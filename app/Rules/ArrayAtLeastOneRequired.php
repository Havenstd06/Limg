<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayAtLeastOneRequired implements Rule
{
    protected $result;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($result)
    {
        $this->result = $result;
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
        if (!isset($this->result[0])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected image field is required.';
    }
}
