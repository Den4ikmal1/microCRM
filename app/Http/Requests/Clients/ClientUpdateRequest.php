<?php


namespace App\Http\Requests\Clients;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
{
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
        $validates = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients')->ignore($this->client)]
        ];
        return array_merge($this->setValidationForPassword(), $validates);
    }

    public function setValidationForPassword()
    {
        if ($this->password) {
            return [
                'password' => 'required|min:6',
                'passwordConfirmation' => 'required_with:password|same:password'
            ];
        } else {
            return [
                'password' => 'nullable',
                'passwordConfirmation' => 'nullable'
            ];
        }
    }
}