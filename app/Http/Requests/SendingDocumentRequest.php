<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendingDocumentRequest extends FormRequest
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
            'document_no'   => 'required|max:255',
            'title' => 'required',
            'source' => 'required',
            'destination' => 'required',
            'document_type_id' => 'required'
        ];
    }

    public function messages()
{
    return [
        'document_no.required'    => 'หมายเลขทะเบียนหนังสือ จำเป็นจะต้องกรอก',
        'title.required'  => 'ชื่อเรื่อง จำเป็นจะต้องกรอก',
        'source.required' => 'ต้นสังกัด จำเป็นจะต้องกรอก',
        'destination.required' => 'ปลายทางหนังสือ จำเป็นจะต้องกรอก',
        'document_type_id.required' => 'ประเภทเอกสาร จำเป็นจะต้องกรอก'
    ];
}
}