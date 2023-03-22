<?php

namespace App\Http\Requests\Web;

use App\Http\Validation\HasSearchRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use HasSearchRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->searchRules();
    }
}
