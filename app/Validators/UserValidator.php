<?php

namespace App\Validators;

class UserValidator extends Validator
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
                    'first_name' => 'required|max:255',
                    'last_name'  => 'required|max:255',
                    'username'   => 'required|email|max:255|unique:users',
                    'password'   => 'required|min:9|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@!$&%#*?+]).+$/',
                ]; 
            break;

            case 'update':
                $rules = [
                    'first_name' => 'required|max:255',
                    'last_name'  => 'required|max:255',
                    'password'   => 'required|min:9|max:255|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@!$&%#*?+]).+$/',
                ]; 
            break;
        }

        return $rules;
    }

    protected function messages($type)
    {
        $messages = [];

        switch($type)
        {
            case 'create':
                $messages = [
                    'username.unique' => 'user already exists with given :attribute',
                    'password.regex'  => ':attribute should have at least 1 lowercase, 1 uppercase, 1 number and 1 special character',
                ]; 
            break;

            case 'update':
                $messages = [
                    'username.unique' => 'user already exists with given :attribute',
                    'password.regex'  => ':attribute should have at least 1 lowercase, 1 uppercase, 1 number and 1 special character',
                ]; 
            break;
        }

        return $messages;
    }
}
