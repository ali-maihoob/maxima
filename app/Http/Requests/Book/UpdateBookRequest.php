<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('book.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() === 'PUT') {
            return [
                'title' => 'required|string|max:255',
                'author' => 'required|string',
                'publication_date' => 'required|date',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }
        else {
            return [
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string',
                'publication_date' => 'sometimes|required|date',
                'description' => 'sometimes|nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        }
    }
}
