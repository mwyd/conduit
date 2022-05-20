<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpayBotPresetRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->preset) {
            $this->merge(['preset' => json_decode($this->preset, true)]);
        }
    }

    public function rules(): array
    {
        $rules = [
            'preset' => 'required|array'
        ];

        if ($this->method() == self::METHOD_PUT) {
            $rules['preset'] = str_replace('required', 'sometimes', $rules['preset']);
        }

        return $rules;
    }
}
