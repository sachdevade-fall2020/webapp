<?php

namespace App\Validators;

class FileValidator extends Validator
{
    /**
    * Validation rules.
    *
    * @param  string $type
    * @param  array $data
    * @return array
    */

    protected function rules($data, $type)
    {
        $rules = [];

        switch($type)
        {
            case 'create':
                $rules = [
                    'attachment' => 'required|file|mimes:jpg,jpeg,png|max:2048'
                ]; 
            break;
        }

        return $rules;
    }

    protected function messages($type)
    {
        $messages = [];

        return $messages;
    }
}
