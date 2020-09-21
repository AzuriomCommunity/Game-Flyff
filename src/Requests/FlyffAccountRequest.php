<?php

namespace Azuriom\Plugin\Flyff\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Azuriom\Plugin\Flyff\Models\FlyffAccount;
use Azuriom\Games\Others\Servers\FlyffServerBridge;

class FlyffAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        

        return [
            'account' => ['required', 'string', 'max:25', 
                function ($attribute, $value, $fail) {
                    $test = FlyffAccount::where('account', $value)->first();
                    if ($test) {
                        $fail($attribute.' already exists.');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ];
    }
}