<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException as Exception;

class ValidationException extends Exception
{
	protected $inputs;

	function __construct($validator, $inputs)
	{
		parent::__construct($validator);
	  	$this->inputs = $inputs;
	}

	public function errors()
	{
	  return $this->validator->errors();
	}

	public function inputs()
	{
	  return $this->inputs;
	}
}