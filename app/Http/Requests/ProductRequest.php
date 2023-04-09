<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255|min:3',
            // 'slug' => 'string|unique:products,slug',
            'category_id' => 'sometimes|required|exists:categories,id',
            // 'store_id' => 'required|exists:stores,id',
            'description' => 'nullable|string',
            'quantity' =>'numeric',
            'status' => 'in:in-stock,sold-out,draft',
            'image' => 'image',
            'price' => 'numeric|min:0',
            'sale_price' => ['numeric','min:0', function($attr,$value,$fail){

                    $price = request()->input('price');
                    if($value >= $price){
                        $fail($attr.' must be less than regular price');
                    }
            },]

        ];
    }
}
