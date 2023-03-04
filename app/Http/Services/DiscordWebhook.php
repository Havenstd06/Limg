<?php

namespace App\Http\Services;

use DiscordWebhooks\Client;
use DiscordWebhooks\Embed;

class DiscordWebhook
{
    private $user;
    private $image;

    public function __construct($user, $image)
    {
        $this->user = $user;
        $this->image = $image;
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function sendWebhook()
    {
        $webhook = new Client($this->user->webhook_url);
        $embed = new Embed();

        $embed->title('New image uploaded!', route('image.show', ['image' => $this->image]));
        $embed->image(config('app.url').$this->image->path);
        $embed->author($this->user->username, route('user.profile', ['user' => $this->user]), url($this->user->avatar));
        $embed->footer(config('app.url'), config('app.url').'/images/favicon/favicon-32x32.png');
        $embed->timestamp(date('c'));
        $embed->color('7041F6');

        $webhook->username(config('app.name'))->avatar(config('app.url').'/images/favicon/apple-touch-icon.png')->embed($embed)->send();
    }
}
