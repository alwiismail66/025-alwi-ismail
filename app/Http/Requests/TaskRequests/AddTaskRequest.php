<?php

namespace App\Http\Requests\TaskRequests;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
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
    public function attributes(): array
    {
        $attributes = [];
        $subtasks = $this->input('subtask', []);

        foreach ($subtasks as $index => $value) {
            $attributes["subtask.$index"] = "subtask " . ($index + 1);
        }

        return $attributes;
    }
    public function rules(): array
    {
        return [
            'name-task' => ['required', 'string', 'max:50'],
            'notice' => ['nullable', 'string', 'max:300'],
            'for-date' => ['required', 'date_format:Y-m-d'],
            'start-at' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'date_format:H:i'],
            'subtask.*' => ['nullable', 'string', 'max:50'],
        ];
    }
}
