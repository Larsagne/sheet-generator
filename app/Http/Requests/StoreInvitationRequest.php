<?php

namespace App\Http\Requests;

use App\Facades\Harmony;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'invitable_id' => 'string|required',
            'invitable_type' => 'string|required',
            'email' => 'required|email',
        ];
    }
}
