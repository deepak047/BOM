<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BomUploadRequest extends FormRequest
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
            'project_id' => 'required|exists:projects,id',
            'bom_file'   => 'required|file|mimes:xls,xlsx,csv|max:20480', // 20MB Max S
        ];
    }

    public function messages(): array
    {
        return [
            'bom_file.mimes' => 'Only .xls, .xlsx, and .csv files are allowed.',
        ];
    }
}

