<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Private()
 * @method static static Discover()
 * @method static static Public()
 */
final class ImageStateType extends Enum
{
    const Private = 0;
    const Discover = 1;
    const Public = 2;
}
