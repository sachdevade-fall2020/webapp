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
                ]; 
            break;

            case 'update':
                $rules = [
                    'question_text' => 'required|max:255',
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
