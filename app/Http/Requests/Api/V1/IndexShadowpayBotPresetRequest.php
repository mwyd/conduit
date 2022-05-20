<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpayBotPresetRequest extends FormRequest
{
    use HasOrderRules, HasPaginationRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->orderRules(['updated_at']),
            ...$this->paginationRules()
        ];
    }
}
