<?php

namespace App\Observers;

use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * Handle the image "created" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function created(Image $image)
    {
        //
    }

    /**
     * Handle the image "updated" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function updated(Image $image)
    {
        //
    }

    /**
     * Handle the image "deleted" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        Storage::disk('public')->delete('images/'.$image->fullname);
    }

    /**
     * Handle the image "restored" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function restored(Image $image)
    {
        //
    }

    /**
     * Handle the image "force deleted" event.
     *
     * @param  \App\Image  $image
     * @return void
     */
    public function forceDeleted(Image $image)
    {
        //
    }
}
