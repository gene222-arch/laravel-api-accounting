<?php

namespace App\Http\Requests\Upload;

use App\Http\Requests\BaseRequest;

class UploadImageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:1999']
        ];
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.image' => 'The file must be an image.'
        ];
    }
}
