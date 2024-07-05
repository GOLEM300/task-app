<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class TaskIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => [Rule::enum(TaskStatus::class)],
            'date_to_finish' => 'date|date_format:Y-m-d|after_or_equal:date_create'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date_to_finish.date' => 'Поле date_create должно быть датой',
            'date_to_finish.date_format' => 'Поле date_create должно быть формата Y-m-d',
            'date_to_finish.after_or_equal' => 'Поле date_to_finish должно быть больше или равно date_create',
            'status.required' => 'Поле status должно обязательно'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
