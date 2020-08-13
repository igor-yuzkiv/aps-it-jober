<?php

namespace App\Http\Requests\JobLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateJobLogRequest extends FormRequest
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
            "services_item_id" => ["required"],
            "user_exec" => "required",
            "client_id" => "required",
            "coefficient" => "min:1",
            "count" => "min:1",
        ];
    }
}
