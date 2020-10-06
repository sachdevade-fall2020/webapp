<?php

namespace App\Validators;

class QuestionValidator extends Validator
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
                    'question_text' => 'required|max:255',
                    'categories'    => 'array',
                    'categories.*'  => 'distinct',
                ]; 
            break;

            case 'update':
                $rules = [
                    'question_text' => 'required|max:255',
                    'categories'    => 'array',
                    'categories.*'  => 'distinct',
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
