<?php

namespace App\Http\Requests;

use App\Facades\Harmony;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSheetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'artist' => 'string|max:255',
            'duration' => 'int',
            'tempo' => 'int',
            'key' => ['string', Rule::in(array_column(Harmony::getKeys(), 'shortName'))],
            'time_signature' => 'string|regex:^\d+/\d+$',
            'parts' => 'array'
        ];
    }
}
