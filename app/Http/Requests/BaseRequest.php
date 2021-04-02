<?php

namespace App\Http\Requests;

use App\Traits\Api\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{

    use ApiResponser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check() === true;
    }


    /**
     * Throws an error response code of 422 with its messages in JSON format
     * 
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson())
        {
            $errors = [];

            foreach ($validator->errors()->getMessages() as $key => $value) 
            {
                $errors[$key] = $value[array_key_first($value)];
            }

            throw new HttpResponseException(
                $this->error($errors, 422));
        }
    }

    /**
     * Customize the error message
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.exists' => 'The selected :attribute does not exist.',
            'ids.*.exists' => 'The selected :attribute does not exist.'
        ];
    }

}
