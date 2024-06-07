<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class StoreUserRequest extends FormRequest
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
            'pseudo'   => 'required|string|alpha_dash|min:3|max:25|unique:users',
            'email'    => 'required|email|unique:users|max:255',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' =>
            [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }

    public function messages()
    {
        return [
            /*
            |--------------------------------------------------------------------------|
            |   messages PSEUDO                                                        |
            |--------------------------------------------------------------------------|
            */
            'pseudo.required' => 'Le pseudo est requis.',
            'pseudo.string'   => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.min'      => 'Le pseudo doit faire au moins 3 caractères.',
            'pseudo.max'      => 'Le pseudo ne doit pas dépasser 25 caractères.',
            'pseudo.unique'   => 'Pseudo déjà utilisé.',

            /*
            |--------------------------------------------------------------------------|
            |   messages EMAIL                                                         |
            |--------------------------------------------------------------------------|
            */
            'email.required' => 'L\'email est requis.',
            'email.email'    => 'Email invalide.',
            'email.unique'   => 'Email déjà utilisé.',
            'email.max'      => 'L\'email ne doit pas dépasser 255 caractères.',

            /*
            |--------------------------------------------------------------------------|
            |   messages IMAGE                                                         |
            |--------------------------------------------------------------------------|
            */
            'image.image' => 'L\'image doit être un fichier de type image.',
            'image.mimes' => 'L\'image doit être un fichier de type jpg, jpeg, png ou svg.',
            'image.max'   => 'L\'image ne doit pas dépasser 2 Mo.',

            /*
            |--------------------------------------------------------------------------|
            |   messages PASSWORD                                                         |
            |--------------------------------------------------------------------------|
            */
            'password.required'   => 'Le mot de passe est requis.',
            'password.confirmed'  => 'La confirmation du mot de passe est incorrecte.',
            'password.string'     => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min'        => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.mixed_case' => 'Le mot de passe doit contenir des lettres majuscules et minuscules.',
            'password.letters'    => 'Le mot de passe doit contenir des lettres.',
            'password.numbers'    => 'Le mot de passe doit contenir des chiffres.',
            'password.symbols'    => 'Le mot de passe doit contenir des caractères spéciaux.',
        ];
    }
}
