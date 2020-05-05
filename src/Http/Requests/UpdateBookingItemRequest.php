<?php

namespace Selene\Modules\BookingModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string',
            'order' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'To pole jest wymagane!',
            '*.string' => 'To pole musi być ciągiem znaków!',
            '*.unique' => 'To pole musi być unikalne!',
            '*.numeric' => 'To pole musi być numerem!',
        ];
    }
}
