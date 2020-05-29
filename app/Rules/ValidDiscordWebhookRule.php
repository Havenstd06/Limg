<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDiscordWebhookRule implements Rule
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
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        if (parse_url($value)['host'] == 'discordapp.com' || parse_url($value)['host'] == 'ptb.discordapp.com') {
            $client = new \GuzzleHttp\Client();
            try {
                $r = $client->request('GET', $value);
            } catch (\Exception $e) {
                return false;
            }
            $c = $r->getBody()->getContents();
            if ($r->getStatusCode() != 200) {
                return false;
            }
            if ($r->getHeaderLine('content-type') == 'application/json') {
                $json = json_decode($c);
            } else {
                return false;
            }

            if ($r->getStatusCode() == 200) {
                if (isset($json->type) && isset($json->id) && isset($json->name) && isset($json->channel_id) && isset($json->guild_id) && isset($json->token)) {
                    return true;
                } else {
                    return false;
                }
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
        return 'Your Discord webhook URL is not valid.';
    }
}
