<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertCsgoBlueGemItemRequest extends FormRequest
{
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
        $rules = [
            'paint_seed'    => 'required|integer',
            'item_type'     => ['required', Rule::in([
                '★ Bayonet',
                '★ Bowie Knife',
                '★ Butterfly Knife',
                '★ Classic Knife',
                '★ Falchion Knife',
                '★ Flip Knife',
                '★ Gut Knife',
                '★ Huntsman Knife',
                '★ Karambit',
                '★ M9 Bayonet',
                '★ Navaja Knife',
                '★ Nomad Knife',
                '★ Paracord Knife',
                '★ Shadow Daggers',
                '★ Skeleton Knife',
                '★ Stiletto Knife',
                '★ Survival Knife',
                '★ Talon Knife',
                '★ Ursus Knife',
                'AK-47',
                'Five-SeveN'
            ])],
            'gem_type'      => ['required', Rule::in([
                'Blue',
                'Gold',
                'Tier 2',
                'Tier 3'
            ])]
        ];

        if($this->method() == self::METHOD_PUT) 
        {
            foreach($rules as $key => $rule) $rules[$key] = str_replace('required', 'sometimes', $rule);
        }

        return $rules;
    }
}
