<?php

namespace App\Http\Requests;

use App\Library\JsonResponseData;
use App\Library\Message;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BikeMapRequest extends FormRequest {
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            JsonResponseData::formatData(
                $this,
                'Validation Failed',
                Message::MESSAGE_ERROR,
                [
                    'errors' => $validator->errors(),
                    'status' => true,
                ])
            , 422));
    }
}
