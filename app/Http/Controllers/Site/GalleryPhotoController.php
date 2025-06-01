<?php

namespace App\Http\Controllers\Site;

use App\Models\GalleryPhoto;

class GalleryPhotoController
{

    public function iframe(GalleryPhoto $galleryPhoto)
    {
        $galleryPhoto->load('media');

        return view('site.galleryPhotos.iframe', compact('galleryPhoto'));
    }

}
