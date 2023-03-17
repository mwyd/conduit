<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpsertShadowpayBotConfigRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('config')) {
            $this->merge(['config' => json_decode($this->input('config'), true)]);
        }
    }

    public function rules(): array
    {
        $rules = [
            'config' => 'required|array'
        ];

        if ($this->method() == self::METHOD_PUT) {
            $rules['config'] = str_replace('required', 'sometimes', $rules['config']);
        }

        return $rules;
    }
}
