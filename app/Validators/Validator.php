<?php

namespace App\Validators;

use Illuminate\Validation\Factory;
use App\Exceptions\ValidationException;

abstract class Validator
{
  /**
   * The validator instance.
   *
   * @var \Illuminate\Validation\Factory
   */
  protected $validator;

  /**
  * Create a new validator instance.
  *
  * @param \Illuminate\Validation\Factory $validator
  */
  function __construct(Factory $validator)
  {
    $this->validator = $validator;
  }

  /**
  * Fire validation of given type.
  *
  * @param array  $inputs
  * @param string $type
  * @param array  $data
  * @return bool
  *
  * @throws \App\Exceptions\ValidationException
  */
  public function fire($inputs, $type, $data = [])
  {
    $validation = $this->validator->make(
                                $inputs,
                                $this->rules( $data, $type),
                                $this->messages($type)
                              );

    $validation->setAttributeNames($this->getAttributeNamesForHuman($type));

    if($validation->fails()) {
      throw new ValidationException($validation, $inputs);
    } else {
      return true;
    }
  }

  /**
   * validation messages
   *
   * @return array
   */
  protected function messages($type)
  {
    return [];
  }

  /**
   * Get the attributes name.
   *
   * @return array
   */
  protected function getAttributeNamesForHuman($type)
  {
    return [];
  }

  /**
   * validation rules
   *
   * @return array
   */
  abstract protected function rules($data, $type);
}
