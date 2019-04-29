<?php


namespace App\Http\Requests\Projects;


use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('projects')->ignore($this->project)],
            'description' => ['string'],
            'status' => ['required', 'numeric', Rule::in(Project::getKeyStatuses())],
        ];
    }
}
