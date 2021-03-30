<?php

namespace App\Traits\Upload;

use Illuminate\Support\Facades\Storage;

trait ImageUpload
{
    /**
     * File upload
     *
     * @param  $request
     * @param  string $property
     * @param  string $pathToStore
     * @return string
     */
    public function uploadImage($request, string $property, string $pathToStore): string
    {
        $path = '';
        
        if ($request->hasFile($property))
        {
            $file = $request->{$property};

            $original = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $fileName = pathinfo($original, PATHINFO_FILENAME);

            $fileToStore = "${fileName}_" . time() . ".${ext}";

            $path = $file->storeAs($pathToStore, $fileToStore, 'public');
        }

        return Storage::disk('public')->url($path);
    }

}