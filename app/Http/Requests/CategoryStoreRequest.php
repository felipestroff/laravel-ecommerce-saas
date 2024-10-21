<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        // A regra 'unique:categories,name' garante que o nome seja único
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Verifica a unicidade do nome da categoria, considerando o user_id
                Rule::unique('categories', 'name')
                    ->where('user_id', Auth::id())
                    ->ignore($this->category?->id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Uma categoria com este nome já existe.',
        ];
    }
}
