<?php

namespace App\Validators;

class AnswerValidator extends Validator
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
                    'answer_text' => 'required|max:255',
                ]; 
            break;

            case 'update':
                $rules = [
                    'answer_text' => 'required|max:255',
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
