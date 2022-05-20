<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasDateRules;
use Illuminate\Foundation\Http\FormRequest;

class ShowShadowpaySoldItemRequest extends FormRequest
{
    use HasDateRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->dateRules();
    }
}
