<?php

/**
 * UploadImage helper
 *
 * @param $request
 *
 */

function uploadImage($image)
{
    $imageName = time() . '.' . $image->extension();
    $image->move(public_path('image'), $imageName);

    return $imageName;
}
