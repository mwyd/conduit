<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Traits\HasApiValidation;
use Illuminate\Foundation\Http\FormRequest;

class IndexShadowpayFriendRequest extends FormRequest
{
    use HasApiValidation;

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->apiValidationRules([
            'order_by'  => [
                'created_at',
                'name'
            ]
        ]);
    }
}
