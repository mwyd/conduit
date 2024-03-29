<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Validation\HasOrderRules;
use App\Http\Validation\HasPaginationRules;
use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpayFriendRequest extends FormRequest
{
    use HasOrderRules, HasPaginationRules, HasSearchRules;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            ...$this->searchRules(),
            ...$this->orderRules([
                'created_at',
                'name',
            ]),
            ...$this->paginationRules(),
        ];
    }
}
