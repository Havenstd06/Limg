<?php

namespace App\Http\Services;

use App\Enums\ImageStateType;
use Illuminate\Support\Facades\Auth;

class ImageIsPublic
{
    private $user;
    private $isApi;

    public function __construct($user, $isApi)
    {
        $this->user = $user;
        $this->isApi = $isApi;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function imageState()
    {
        $imageState = ImageStateType::Public;

        if ((Auth::check() || $this->isApi) && (!$this->user->always_public && !$this->user->always_discover)) {
            $imageState = ImageStateType::Private;
        }

        if ((Auth::check() || $this->isApi) && ($this->user->always_public && !$this->user->always_discover)) {
            $imageState = ImageStateType::Public;
        }

        if (! (Auth::check() || $this->isApi) || ($this->user->always_public && $this->user->always_discover)) {
            $imageState = ImageStateType::Discover;
        }

        return $imageState;
    }
}
