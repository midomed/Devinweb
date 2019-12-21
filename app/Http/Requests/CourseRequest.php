<?php

namespace App\Http\Requests;

use App\Course;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class CourseRequest extends FormRequest
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
        $slug = $this->input('slug', '');
        $course = Course::where('slug', $slug)->first();
        $id_str = ($course) ? ',' . $course->id : '';

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required|unique:courses,slug'.$id_str  ,
            'image' => 'mimes:'.implode(',',config('imageable.mimes')).'|max:'.config('imageable.max_file_size'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => 'The category_id field is required.',
            'category_id.exists' => 'Category id don\'t existe.',
            'name.required' => 'The name field is required.',
            'description.required' => 'The description field is required.',
            'image.max' => 'Image size not valide.',
            'slug.unique' => 'The slug has already been taken.',
            'slug.required' => 'The slug field is required.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['message'=>'The given data was invalid.','errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

}
