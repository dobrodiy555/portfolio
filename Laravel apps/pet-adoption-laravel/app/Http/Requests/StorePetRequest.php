<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StorePetRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
	    return [
		    'type' => ['required', Rule::in(['dog', 'cat'])],
		    'name' => ['required', 'min:3', 'max:100'],
		    'age' => ['required', 'digits_between:1,25'],
		    'breed' => 'required',
		    'gender' => ['required', Rule::in(['male', 'female'])],
		    'photo' => ['required', File::types(['jpg', 'png', 'webp'])],
	    ];

    }
}
