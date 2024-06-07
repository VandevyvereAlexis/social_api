<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'content' => 'required|string|min:5|max:255',
            'tags'    => 'nullable|string|min:3|max:50',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required',
            'post_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            /*
            |--------------------------------------------------------------------------|
            |   messages CONTENU                                                       |
            |--------------------------------------------------------------------------|
            */
            'content.required' => 'Le contenu est requis.',
            'content.string'   => 'Le contenu doit être une chaîne de caractères.',
            'content.min'      => 'Le contenu doit faire au moins 5 caractères.',
            'content.max'      => 'Le contenu ne doit pas dépasser 255 caractères.',

            /*
            |--------------------------------------------------------------------------|
            |   messages TAGS                                                          |
            |--------------------------------------------------------------------------|
            */
            'tags.string' => 'Les tags doivent être une chaîne de caractères.',
            'tags.min'    => 'Les tags doivent faire au moins 3 caractères.',
            'tags.max'    => 'Les tags ne doivent pas dépasser 50 caractères.',

            /*
            |--------------------------------------------------------------------------|
            |   messages IMAGE                                                         |
            |--------------------------------------------------------------------------|
            */
            'image.image' => 'L\'image doit être un fichier de type image.',
            'image.mimes' => 'L\'image doit être un fichier de type jpg, jpeg, png ou svg.',
            'image.max'   => 'L\'image ne doit pas dépasser 2 Mo.',
        ];
    }
}
