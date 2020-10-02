<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Private()
 * @method static static Public()
 * @method static static Discover()
 */
final class ImageStateType extends Enum
{
    const Private = 0;
    const Public = 1;
    const Discover = 2;
}
