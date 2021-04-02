<?php

namespace App\Traits\Upload;

use Illuminate\Support\Facades\Storage;

trait UploadServices
{
    /**
     * File upload
     *
     * @param  $request
     * @param  string $pathToStore
     * @return string
     */
    public function uploadImage($request, string $pathToStore): string
    {
        $path = '';
        
        if ($request->hasFile('image'))
        {
            $file = $request->image;

            $original = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $fileName = pathinfo($original, PATHINFO_FILENAME);

            $fileToStore = "${fileName}_" . time() . ".${ext}";

            $path = $file->storeAs($pathToStore, $fileToStore, 'public');
        }

        return Storage::disk('public')->url($path);
    }

}