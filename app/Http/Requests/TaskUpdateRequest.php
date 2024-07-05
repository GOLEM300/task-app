<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:200|unique:tasks,title',
            'description' => 'required|string|max:1000',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'date_create' => 'required|date|date_format:Y-m-d',
            'date_to_finish' => 'required|date|date_format:Y-m-d|after_or_equal:date_create'
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
            'title.required' => 'Название задачи обязательно',
            'title.unique' => 'Название задачи занято',
            'title.max' => 'Название задачи не должно превышать 200 символов',
            'description.required' => 'Описание задачи обязательно',
            'description.max' => 'Описание задачи не должно превышать 1000 символов',
            'date_create.required' => 'Поле date_create обязательно',
            'date_create.date' => 'Поле date_create должно быть датой',
            'date_create.date_format' => 'Поле date_create должно быть формата Y-m-d',
            'date_to_finish.required' => 'Поле date_create обязательно',
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
